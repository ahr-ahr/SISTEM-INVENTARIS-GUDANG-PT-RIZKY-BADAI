<?php

namespace App\Services\Inventory;

use App\Models\Inventory\Barang;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class BarangService
{
    private const CACHE_TAG = 'barang';

    public function getActive(): Collection
    {
        if (App::environment('testing')) {
            return Barang::active()->get();
        }

        return Cache::tags(self::CACHE_TAG)->remember(
            'barang:list:active',
            now()->addMinutes(10),
            fn () => Barang::active()->get()
        );
    }

    public function getInactive(): Collection
    {
        if (App::environment('testing')) {
            return Barang::inactive()->get();
        }
        return Cache::tags(self::CACHE_TAG)->remember(
            'barang:list:inactive',
            now()->addMinutes(10),
            fn () => Barang::inactive()->get()
        );
    }

    public function create(array $data): Barang
    {
        return DB::transaction(function () use ($data) {
            $barang = Barang::create($data);

            $this->flushCache();

            return $barang;
        });
    }

    public function update(Barang $barang, array $data): Barang
    {
        return DB::transaction(function () use ($barang, $data) {
            $barang->update($data);

            $this->flushCache();

            return $barang;
        });
    }

    public function deactivate(Barang $barang, string $reason, int $userId): Barang
    {
        return DB::transaction(function () use ($barang, $reason, $userId) {
            $barang->update([
                'is_active'          => false,
                'deactivated_reason' => $reason,
                'deactivated_at'     => now(),
                'deactivated_by'     => $userId,
            ]);

            $this->flushCache();

            return $barang;
        });
    }

    private function flushCache(): void
    {
        Cache::tags(self::CACHE_TAG)->flush();
    }
}
