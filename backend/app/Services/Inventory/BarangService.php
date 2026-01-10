<?php

namespace App\Services\Inventory;

use App\Models\Inventory\Barang;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BarangService
{
    public function getActive(): Collection
    {
        return Barang::active()->get();
    }

    public function getInactive(): Collection
    {
        return Barang::inactive()->get();
    }

    public function create(array $data): Barang
    {
        return DB::transaction(fn () => Barang::create($data));
    }

    public function update(Barang $barang, array $data): Barang
    {
        return DB::transaction(function () use ($barang, $data) {
            $barang->update($data);
            return $barang;
        });
    }

    public function deactivate(Barang $barang, string $reason, int $userId): Barang
    {
        return DB::transaction(function () use ($barang, $reason, $userId) {
            $barang->update([
                'is_active' => false,
                'deactivated_reason' => $reason,
                'deactivated_at' => now(),
                'deactivated_by' => $userId,
            ]);

            return $barang;
        });
    }
}
