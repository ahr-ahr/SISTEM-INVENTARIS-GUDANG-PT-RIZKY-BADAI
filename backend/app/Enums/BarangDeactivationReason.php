<?php

namespace App\Enums;

enum BarangDeactivationReason: string
{
    case RUSAK = 'rusak';
    case HILANG = 'hilang';
    case OBSOLETE = 'obsolete';
    case EXPIRED = 'expired';
    case SALAH_INPUT = 'salah_input';

    public function label(): string
    {
        return match ($this) {
            self::RUSAK => 'Barang rusak',
            self::HILANG => 'Barang hilang',
            self::OBSOLETE => 'Barang tidak digunakan lagi',
            self::EXPIRED => 'Kadaluarsa',
            self::SALAH_INPUT => 'Salah input data',
        };
    }
}
