<?php

namespace App\Support;

class ApiMeta
{
    public static function make(): array
    {
        return [
            'copyright'   => '© 2026 Sistem Inventaris Gudang PT Rizky Badai',
            'author'      => 'Ahmad Haikal Rizal & Alifian Putra Wijaya',
            'institution' => 'SMK 17 AGUSTUS 1945',
            'version'     => '1.0',
        ];
    }

    public static function withTimestamp(): array
    {
        return array_merge(
            self::make(),
            ['timestamp' => now()->toIso8601String()]
        );
    }
}
