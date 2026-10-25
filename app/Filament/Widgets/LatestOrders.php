<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';

    // Mengatur agar tabel memenuhi lebar halaman (opsional)
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Mengambil data pesanan diurutkan dari yang paling baru
                Order::query()->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pembeli')
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_payment')
                    ->label('Total Bayar')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success', 'completed', 'paid' => 'success',
                        'pending' => 'warning',
                        'cancelled', 'failed' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Pesan')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
