<?php

namespace App\Services\Inventory\Report;

use App\Models\Inventory\Barang;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StokSnapshotService
{
    public function paginate(array $filter): LengthAwarePaginator
    {
        $query = Barang::query()
            ->where('is_active', true)
            ->orderBy('nama');

        if (!empty($filter['keyword'])) {
            $query->where(function ($q) use ($filter) {
                $q->where('nama', 'like', "%{$filter['keyword']}%")
                  ->orWhere('kode', 'like', "%{$filter['keyword']}%");
            });
        }

        if (isset($filter['stok_min'])) {
            $query->where('stok', '>=', $filter['stok_min']);
        }

        if (isset($filter['stok_max'])) {
            $query->where('stok', '<=', $filter['stok_max']);
        }

        return $query->paginate($filter['per_page'] ?? 20);
    }
}
