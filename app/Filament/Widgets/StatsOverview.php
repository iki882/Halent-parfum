<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProductResource;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Order::whereNotIn('status', ['cancelled', 'failed'])->sum('total_payment');
        $totalExpense = Expense::sum('amount');
        $netProfit = $totalRevenue - $totalExpense;

        $totalProducts = Product::sum('stock');

        return [
            Stat::make('Total Pemasukan', 'Rp '.number_format($totalRevenue, 0, ',', '.'))
                ->description('Dari penjualan produk')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Pengeluaran', 'Rp '.number_format($totalExpense, 0, ',', '.'))
                ->description('Biaya operasional / stok')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Laba Bersih / Saldo', 'Rp '.number_format($netProfit, 0, ',', '.'))
                ->description('Pemasukan - Pengeluaran')
                ->descriptionIcon('heroicon-m-wallet')
                ->color('primary'),

            Stat::make('Total Stok Produk', $totalProducts.' Produk')
                ->description('Klik untuk mengelola produk')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info')
                ->url(ProductResource::getUrl()),
        ];
    }
}
