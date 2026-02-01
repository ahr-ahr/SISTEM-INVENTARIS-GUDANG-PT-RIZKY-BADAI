<?php

namespace App\Services\Inventory\Report;

use App\Models\Inventory\Warehouses\WarehouseStock;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StokSnapshotService
{
    public function paginate(array $filter): LengthAwarePaginator
    {
        $query = WarehouseStock::query()
            ->with([
                'barang',
                'warehouse',
                'location',
            ])
            ->orderBy('warehouse_id')
            ->orderBy('location_id');

        /*
        |--------------------------------------------------------------------------
        | FILTER BARANG
        |--------------------------------------------------------------------------
        */
        if (!empty($filter['barang_id'])) {
            $query->where('barang_id', $filter['barang_id']);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER WAREHOUSE
        |--------------------------------------------------------------------------
        */
        if (!empty($filter['warehouse_id'])) {
            $query->where('warehouse_id', $filter['warehouse_id']);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER LOCATION
        |--------------------------------------------------------------------------
        */
        if (!empty($filter['location_id'])) {
            $query->where('location_id', $filter['location_id']);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KEYWORD (barang)
        |--------------------------------------------------------------------------
        */
        if (!empty($filter['keyword'])) {
            $query->whereHas('barang', function ($q) use ($filter) {
                $q->where('nama', 'like', "%{$filter['keyword']}%")
                  ->orWhere('kode', 'like', "%{$filter['keyword']}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STOK
        |--------------------------------------------------------------------------
        */
        if (isset($filter['stok_min'])) {
            $query->where('stok', '>=', $filter['stok_min']);
        }

        if (isset($filter['stok_max'])) {
            $query->where('stok', '<=', $filter['stok_max']);
        }

        return $query->paginate(
            $filter['per_page'] ?? 20
        );
    }
}
