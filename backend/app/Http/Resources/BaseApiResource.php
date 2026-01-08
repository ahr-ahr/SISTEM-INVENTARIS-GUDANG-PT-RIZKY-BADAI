<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseApiResource extends JsonResource
{
    public static function meta(): array
    {
        return [
            'copyright'   => '© 2026 Sistem Inventaris Gudang PT Rizky Badai',
            'author'      => 'Ahmad Haikal Rizal & Alifian Putra Wijaya',
            'institution' => 'SMK 17 AGUSTUS 1945',
            'version'     => '1.0',
            'timestamp'   => now()->toIso8601String(),
        ];
    }
}
