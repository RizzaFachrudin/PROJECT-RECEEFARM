<?php

namespace App\Providers;

use App\Models\Bibit;
use App\Models\Pemanenan;
use App\Models\Penjualan;
use App\Models\Penanaman;
use App\Observers\BibitObserver;
use App\Observers\PemanenanObserver;
use App\Observers\PenjualanObserver;
use App\Observers\PenanamanObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Bibit observer tidak diperlukan lagi karena stok dihitung dari pengadaan
        Pemanenan::observe(PemanenanObserver::class);
        Penjualan::observe(PenjualanObserver::class);
        Penanaman::observe(PenanamanObserver::class);
    }
}
