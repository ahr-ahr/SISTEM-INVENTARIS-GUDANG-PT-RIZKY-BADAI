<?php

use Illuminate\Support\Facades\Route;
use App\Events\BarangMasuk;

Route::get('/test-realtime', function () {
    event(new BarangMasuk([
        'kode' => 'BRG-001',
        'nama' => 'Baut Baja',
        'qty'  => 10,
    ]));

    return response()->json([
        'status' => 'ok',
        'message' => 'Event BarangMasuk dikirim',
    ]);
});

?>