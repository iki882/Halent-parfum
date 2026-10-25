<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Manajemen Toko';

    protected static ?string $pluralModelLabel = 'Pesanan Pelanggan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pesanan')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Nomor Pesanan')
                            ->disabled(),
                        Forms\Components\TextInput::make('product_name')
                            ->label('Nama Produk')
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->label('Harga Produk')
                            ->numeric()
                            ->prefix('Rp ')
                            ->required(),
                        Forms\Components\TextInput::make('shipping_fee')
                            ->label('Ongkos Kirim')
                            ->numeric()
                            ->prefix('Rp ')
                            ->required(),
                        Forms\Components\TextInput::make('total_payment')
                            ->label('Total Pembayaran')
                            ->numeric()
                            ->prefix('Rp ')
                            ->required(),
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'pending' => 'Pending (Menunggu Pembayaran)',
                                'processing' => 'Sedang Diproses / Dikirim',
                                'completed' => 'Pesanan Selesai',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->required()
                            ->native(false),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Pembeli & Pengiriman')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Pembeli')
                            ->required(),
                        Forms\Components\TextInput::make('customer_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->required(),
                        Forms\Components\TextInput::make('customer_email')
                            ->label('Email')
                            ->email(),
                        Forms\Components\TextInput::make('notes')
                            ->label('Catatan Pesanan'),
                        Forms\Components\Textarea::make('shipping_address')
                            ->label('Alamat Lengkap Pengiriman')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono'),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Pembeli')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('product_name')
                    ->label('Produk')
                    ->searchable(),

                // Format angka total pembayaran dengan prefix Rp
                Tables\Columns\TextColumn::make('total_payment')
                    ->label('Total Bayar')
                    ->numeric(decimalPlaces: 0, decimalSeparator: ',', thousandsSeparator: '.')
                    ->prefix('Rp ')
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->color('gray'),

                // SelectColumn untuk mengubah status secara instan dari tabel
                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->selectablePlaceholder(false),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // Akses cepat hubungi WhatsApp pembeli langsung dari tabel
                Tables\Actions\Action::make('whatsapp')
                    ->label('WA')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (Order $record): string => 'https://wa.me/'.preg_replace('/[^0-9]/', '', $record->customer_whatsapp))
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
