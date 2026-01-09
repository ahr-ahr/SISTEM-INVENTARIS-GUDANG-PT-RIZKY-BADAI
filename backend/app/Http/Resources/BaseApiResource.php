<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * BaseApiResource
 *
 * Digunakan sebagai fondasi semua API Resource.
 * Fokus HANYA pada transformasi data.
 * Tidak mengatur success, meta, atau error.
 */
abstract class BaseApiResource extends JsonResource
{
    /**
     * Format tanggal ke ISO 8601 (konsisten untuk semua resource).
     */
    protected function isoDate($date): ?string
    {
        return $date ? $date->toIso8601String() : null;
    }

    /**
     * Cast integer dengan aman.
     */
    protected function int($value): int
    {
        return (int) $value;
    }

    /**
     * Cast boolean dengan aman.
     */
    protected function bool($value): bool
    {
        return (bool) $value;
    }

    /**
     * Helper null-safe untuk field opsional.
     */
    protected function optional($value)
    {
        return $value ?? null;
    }

    /**
     * Extension point:
     * Tambahkan shared logic resource di sini jika diperlukan.
     * (misalnya: formatting, casting, visibility rule, dll)
     */
}
