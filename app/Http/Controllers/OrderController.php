<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product' => [
                'required',
                'string',
                Rule::exists('products', 'slug')->where('is_active', true),
            ],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_whatsapp' => ['required', 'string', 'max:20'],
            'customer_email' => ['required', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:5000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['required', Rule::in(['seabank', 'gopay'])],
        ]);

        $order = DB::transaction(function () use ($request, $validated): Order {
            $product = Product::query()
                ->where('slug', $validated['product'])
                ->where('is_active', true)
                ->lockForUpdate()
                ->firstOrFail();

            if ($product->stock < 1) {
                throw ValidationException::withMessages([
                    'product' => 'Produk ini sedang habis.',
                ]);
            }

            $shippingFee = 15000;
            $unitPrice = (int) $product->price;
            $totalPrice = $unitPrice + $shippingFee;

            // Simpan data dengan mencakup 'total_price' dan 'product_name'
            $order = Order::create([
                'user_id' => $request->user()->getAuthIdentifier(),
                'order_number' => 'ORD-'.now()->format('Ymd').'-'.Str::random(8),
                'product_name' => $product->name, // Agar tampil di kolom Produk Admin
                'price' => $unitPrice,            // Agar tampil harga satuan
                'total_price' => $totalPrice,     // Mengatasi error database column 'total_price'
                'total_payment' => $totalPrice,   // Jaga-jaga jika kolom ini ada
                'shipping_fee' => $shippingFee,
                'customer_name' => $validated['customer_name'],
                'customer_whatsapp' => $validated['customer_whatsapp'],
                'customer_email' => $validated['customer_email'],
                'shipping_address' => $validated['shipping_address'],
                'notes' => $validated['notes'] ?? null,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
            ]);

            // Jika tabel order_items digunakan
            if (method_exists($order, 'items')) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $unitPrice,
                ]);
            }

            $product->decrement('stock');

            return $order;
        });

        return redirect()->away($this->orderWhatsappUrl($order));
    }

    public function sendOrderProofToWhatsapp(Request $request, Order $order): RedirectResponse
    {
        abort_unless(
            (string) $order->user_id === (string) $request->user()->getAuthIdentifier(),
            404
        );

        $order->load('items.product');

        return redirect()->away($this->orderWhatsappUrl($order));
    }

    private function orderWhatsappUrl(Order $order): string
    {
        $order->loadMissing('items.product');

        $paymentMethod = match ($order->payment_method) {
            'seabank' => 'SeaBank (Transfer Rekening)',
            'gopay' => 'GoPay / QRIS',
        };

        $messageLines = [
            'Halo Halent Parfum, saya sudah melakukan pembayaran dan ingin mengirim bukti pembayaran pesanan.',
            '',
            '*Nomor pesanan:* '.$order->order_number,
            '*Nama:* '.str_replace(["\r", "\n"], ' ', $order->customer_name),
            '*WhatsApp pembeli:* '.$order->customer_whatsapp,
            '*Email:* '.$order->customer_email,
        ];

        foreach ($order->items as $item) {
            $messageLines[] = '*Produk:* '.$item->product->name;
            $messageLines[] = '*Jumlah:* '.$item->quantity;
            $messageLines[] = '*Harga produk:* Rp '.number_format((int) $item->price, 0, ',', '.');
        }

        $messageLines[] = '*Ongkos kirim:* Rp '.number_format((int) $order->shipping_fee, 0, ',', '.');
        $messageLines[] = '*Total pembayaran:* Rp '.number_format((int) $order->total_price, 0, ',', '.');
        $messageLines[] = '*Metode pembayaran:* '.$paymentMethod;
        $messageLines[] = '*Alamat pengiriman:*';
        $messageLines[] = $order->shipping_address;
        $messageLines[] = '';
        $messageLines[] = 'Saya akan melampirkan bukti pembayaran pada chat ini.';

        if ($order->notes !== null && $order->notes !== '') {
            $messageLines[] = '*Catatan:* '.$order->notes;
        }

        $query = http_build_query([
            'phone' => config('services.whatsapp.business_phone'),
            'text' => implode("\n", $messageLines),
        ], '', '&', PHP_QUERY_RFC3986);

        return 'https://api.whatsapp.com/send?'.$query;
    }

    public function sendFallbackCheckoutToWhatsapp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product' => ['required', 'string', Rule::in(array_column(config('catalog.fallback_products'), 'slug'))],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_whatsapp' => ['required', 'string', 'max:20'],
            'customer_email' => ['required', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:5000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['required', Rule::in(['seabank', 'gopay'])],
        ]);

        $product = collect(config('catalog.fallback_products'))->firstWhere('slug', $validated['product']);
        abort_if($product === null, 404);

        $paymentMethod = match ($validated['payment_method']) {
            'seabank' => 'SeaBank (Transfer Rekening)',
            'gopay' => 'GoPay / QRIS',
        };
        $shippingFee = (int) config('checkout.shipping_fee');
        $totalPayment = (int) $product['price'] + $shippingFee;
        $messageLines = [
            'Halo Halent Parfum, saya ingin memesan produk berikut.',
            '',
            '*Nama:* '.str_replace(["\r", "\n"], ' ', $validated['customer_name']),
            '*WhatsApp pembeli:* '.$validated['customer_whatsapp'],
            '*Email:* '.$validated['customer_email'],
            '*Produk:* '.$product['name'],
            '*Harga produk:* Rp '.number_format((int) $product['price'], 0, ',', '.'),
            '*Ongkos kirim:* Rp '.number_format($shippingFee, 0, ',', '.'),
            '*Total pembayaran:* Rp '.number_format($totalPayment, 0, ',', '.'),
            '*Metode pembayaran:* '.$paymentMethod,
            '*Alamat pengiriman:*',
            $validated['shipping_address'],
        ];

        if (! empty($validated['notes'])) {
            $messageLines[] = '*Catatan:* '.$validated['notes'];
        }

        $messageLines[] = '';
        $messageLines[] = 'Saya akan mengirim bukti pembayaran pada chat ini.';

        $query = http_build_query([
            'phone' => config('services.whatsapp.business_phone'),
            'text' => implode("\n", $messageLines),
        ], '', '&', PHP_QUERY_RFC3986);

        return redirect()->away('https://api.whatsapp.com/send?'.$query);
    }

    public function index(Request $request): View
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->with('items.product')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10);

        return view('pages.my-orders', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        abort_unless(
            (string) $order->user_id === (string) $request->user()->getAuthIdentifier(),
            404
        );

        $order->load('items.product');

        return view('pages.order-status', compact('order'));
    }
}
