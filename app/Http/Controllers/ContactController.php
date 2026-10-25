<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function sendToWhatsapp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'order_id' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $messageLines = [
            'Halo Halent Parfum,',
            '',
            'Saya ingin menghubungi Halent Parfum.',
            '',
            '*Nama:* '.str_replace(["\r", "\n"], ' ', $validated['name']),
        ];

        if (! empty($validated['order_id'])) {
            $messageLines[] = '*ID Pesanan:* #'.str_replace(["\r", "\n"], ' ', $validated['order_id']);
        }

        $messageLines[] = '*Pesan:*';
        $messageLines[] = $validated['message'];

        $query = http_build_query([
            'phone' => config('services.whatsapp.business_phone'),
            'text' => implode("\n", $messageLines),
        ], '', '&', PHP_QUERY_RFC3986);

        return redirect()->away('https://api.whatsapp.com/send?'.$query);
    }
}
