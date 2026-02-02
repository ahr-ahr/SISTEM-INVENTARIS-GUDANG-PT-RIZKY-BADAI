<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\TransaksiStok;
use Illuminate\Http\Request;

class TransaksiStokController extends Controller
{
    public function index()
    {
        $data = TransaksiStok::with(['barang', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data transaksi stok',
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = TransaksiStok::with(['barang', 'user'])
            ->find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail transaksi stok',
            'data' => $data
        ]);
    }
}
