<?php

namespace App\Services\Inventory\Report;

use App\Models\Inventory\TransaksiStok;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MutasiStokService
{
    public function paginate(array $filter): LengthAwarePaginator
    {
        $query = TransaksiStok::query()
            ->with(['barang', 'user'])
            ->orderByDesc('created_at');

        if (!empty($filter['barang_id'])) {
            $query->where('barang_id', $filter['barang_id']);
        }

        if (!empty($filter['jenis'])) {
            $query->where('jenis', $filter['jenis']);
        }

        if (!empty($filter['sumber'])) {
            $query->where('sumber', $filter['sumber']);
        }

        if (!empty($filter['tanggal_dari'])) {
            $query->whereDate('created_at', '>=', $filter['tanggal_dari']);
        }

        if (!empty($filter['tanggal_sampai'])) {
            $query->whereDate('created_at', '<=', $filter['tanggal_sampai']);
        }

        return $query->paginate($filter['per_page'] ?? 20);
    }
}
