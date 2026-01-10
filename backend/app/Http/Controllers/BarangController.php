<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Cek permission
        if (! $user->canDo('view_barang')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin melihat barang'
            ], 403);
        }

        // Dummy response dulu (belum ke DB)
        return response()->json([
            'success' => true,
            'message' => 'Akses barang diizinkan',
            'data' => [
                'items' => [],
            ],
        ]);
    }
}
