<?php

namespace App\Services\Inventory\Alert;

use App\Models\Inventory\Barang;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StokMinimumService
{
    public function paginate(array $filter): LengthAwarePaginator
    {
        $query = Barang::query()
            ->where('is_active', true)
            ->whereColumn('stok', '<=', 'stok_minimum')
            ->orderBy('stok');

        return $query->paginate($filter['per_page'] ?? 20);
    }
}
