<?php

namespace App\Http\Resources\Inventory\Report;

use App\Http\Resources\BaseApiResource;

class MutasiStokResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->int($this->id),
            'barang'        => [
                'id'   => $this->int($this->barang->id),
                'kode' => $this->barang->kode,
                'nama' => $this->barang->nama,
            ],
            'jenis'         => $this->jenis, // MASUK / KELUAR
            'jumlah'        => $this->int($this->jumlah),
            'stok_sebelum'  => $this->int($this->stok_sebelum),
            'stok_sesudah'  => $this->int($this->stok_sesudah),
            'sumber'        => $this->sumber,
            'keterangan'    => $this->optional($this->keterangan),
            'user'          => $this->user ? [
                'id'   => $this->int($this->user->id),
                'nama' => $this->user->username,
            ] : null,
            'waktu'         => $this->isoDate($this->created_at),
        ];
    }
}
