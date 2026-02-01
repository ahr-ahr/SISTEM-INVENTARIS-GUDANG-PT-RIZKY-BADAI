<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Rate Limiters
use App\Http\RateLimiters\LoginRateLimiter;
use App\Http\RateLimiters\InternalApiRateLimiter;
use App\Http\RateLimiters\SensitiveActionRateLimiter;

// MODELS
use App\Models\Inventory\Barang;
use App\Models\Inventory\Category;
use App\Models\Inventory\Dispatch;
use App\Models\Inventory\LaporanStock;
use App\Models\Inventory\Penerimaan;
use App\Models\Inventory\Pengeluaran;
use App\Models\Inventory\Receiving;
use App\Models\Inventory\StockAdjustment;
use App\Models\Inventory\StokAlert;
use App\Models\Inventory\Supplier;
use App\Models\Inventory\Transfer;
use App\Models\Inventory\Warehouses\Warehouse;
use App\Models\Inventory\Warehouses\WarehouseLocation;
use App\Models\Inventory\Warehouses\WarehouseStock;

// POLICIES
use App\Policies\Inventory\BarangPolicy;
use App\Policies\Inventory\CategoryPolicy;
use App\Policies\Inventory\DispatchPolicy;
use App\Policies\Inventory\LaporanStockPolicy;
use App\Policies\Inventory\PenerimaanPolicy;
use App\Policies\Inventory\PengeluaranPolicy;
use App\Policies\Inventory\ReceivingPolicy;
use App\Policies\Inventory\StockAdjustmentPolicy;
use App\Policies\Inventory\StokAlertPolicy;
use App\Policies\Inventory\SupplierPolicy;
use App\Policies\Inventory\TransferPolicy;
use App\Policies\Inventory\WarehousePolicy;
use App\Policies\Inventory\WarehouseLocationPolicy;
use App\Policies\Inventory\WarehouseStockPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Rate Limiters
        |--------------------------------------------------------------------------
        */
        LoginRateLimiter::register();
        InternalApiRateLimiter::register();
        SensitiveActionRateLimiter::register();

        /*
        |--------------------------------------------------------------------------
        | Inventory Policies
        |--------------------------------------------------------------------------
        */
        Gate::policy(Barang::class, BarangPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Dispatch::class, DispatchPolicy::class);
        Gate::policy(LaporanStock::class, LaporanStockPolicy::class);
        Gate::policy(Penerimaan::class, PenerimaanPolicy::class);
        Gate::policy(Pengeluaran::class, PengeluaranPolicy::class);
        Gate::policy(Receiving::class, ReceivingPolicy::class);
        Gate::policy(StockAdjustment::class, StockAdjustmentPolicy::class);
        Gate::policy(StokAlert::class, StokAlertPolicy::class);
        Gate::policy(Supplier::class, SupplierPolicy::class);
        Gate::policy(Transfer::class, TransferPolicy::class);

        /*
        |--------------------------------------------------------------------------
        | Warehouse Policies
        |--------------------------------------------------------------------------
        */
        Gate::policy(Warehouse::class, WarehousePolicy::class);
        Gate::policy(WarehouseLocation::class, WarehouseLocationPolicy::class);
        Gate::policy(WarehouseStock::class, WarehouseStockPolicy::class);
    }
}
