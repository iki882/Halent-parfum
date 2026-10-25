<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

// --------------------------------------------------------------------------
// 1. Rute untuk Pengunjung (Belum Login / Tamu)
// --------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --------------------------------------------------------------------------
// 2. Rute Publik (Bisa Diakses Tanpa Login)
// --------------------------------------------------------------------------
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// RUTE KHUSUS BEST SELLER (Tampil Tersendiri)
Route::get('/best-seller', function () {
    $bestSellers = [
        [
            'name' => 'Sexy Gravity',
            'slug' => 'Sexy Gravity',
            'category' => 'Unisex Series',
            'price' => 185000,
            'image' => 'assets/gambar1.jpeg',
            'description' => 'Aroma segar dan menenangkan dengan ketahanan ekstra sepanjang hari.',
            'rating' => '4.9',
            'sold' => '1.2k+',
        ],
        [
            'name' => 'Royal Ispahan',
            'slug' => 'Royal Ispahan',
            'category' => 'Men Series',
            'price' => 162000,
            'image' => 'assets/ispahan.jpeg',
            'description' => 'Kombinasi aroma kayu manis dan citrus maskulin yang memikat.',
            'rating' => '5.0',
            'sold' => '2.4k+',
        ],
        [
            'name' => 'Black Opium',
            'slug' => 'black-opium',
            'category' => 'Women Series',
            'price' => 175000,
            'image' => 'assets/black-opium.jpeg',
            'description' => 'Sentuhan kopi dan vanila mewah yang hangat dan manis.',
            'rating' => '4.9',
            'sold' => '1.8k+',
        ],
    ];

    return view('pages.best-seller', compact('bestSellers'));
})->name('bestseller');

Route::get('/shop', function (Request $request) {
    $catalogSlugs = ['men-series', 'women-series', 'unisex'];
    $availableCategorySlugs = Category::query()
        ->whereIn('slug', $catalogSlugs)
        ->whereHas('products', fn ($query) => $query->where('is_active', true))
        ->pluck('slug')
        ->all();

    $filters = $request->validate([
        'category' => ['nullable', Rule::in($availableCategorySlugs)],
    ]);

    $categories = Category::query()
        ->whereIn('slug', $availableCategorySlugs)
        ->orderBy('name')
        ->get();

    $products = Product::query()
        ->with('category')
        ->where('is_active', true)
        ->whereHas('category', function ($query) use ($availableCategorySlugs, $filters) {
            $query->whereIn('slug', $availableCategorySlugs);

            if (! empty($filters['category'])) {
                $query->where('slug', $filters['category']);
            }
        })
        ->orderBy('name')
        ->get();

    return view('components.shop', [
        'categories' => $categories,
        'products' => $products,
        'selectedCategory' => $filters['category'] ?? null,
    ]);
})->name('shop');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/contact/whatsapp', [ContactController::class, 'sendToWhatsapp'])->name('contact.whatsapp');

// --------------------------------------------------------------------------
// 3. Rute Khusus User Terautentikasi (Sudah Login)
// --------------------------------------------------------------------------
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rute Tampilan Form Checkout
    Route::get('/checkout/{product:slug}', function (Product $product) {
        abort_unless($product->is_active, 404);
        $product->load('category');

        return view('pages.checkout', compact('product'));
    })->name('checkout');

    // Rute Proses Transaksi & Antrean Pesanan (OrderController)
    Route::post('/checkout/store', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');

});

// Group Admin (Bisa Dilindungin oleh middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/order', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});
