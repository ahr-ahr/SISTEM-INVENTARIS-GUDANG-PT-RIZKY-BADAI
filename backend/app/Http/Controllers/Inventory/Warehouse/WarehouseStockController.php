<?php

namespace App\Http\Controllers\Inventory\Warehouse;

use App\Http\Controllers\Controller;
use App\Services\Inventory\Warehouse\WarehouseStockService;
use App\Http\Resources\Inventory\WarehouseStock\WarehouseStockResource;
use App\Http\Resources\Inventory\WarehouseStock\WarehouseStockCollection;
use App\Http\Requests\Inventory\WarehouseStock\IncreaseWarehouseStockRequest;
use App\Http\Requests\Inventory\WarehouseStock\DecreaseWarehouseStockRequest;
use App\Http\Requests\Inventory\WarehouseStock\ReserveWarehouseStockRequest;
use App\Http\Requests\Inventory\WarehouseStock\TransferWarehouseStockRequest;
use App\Http\Requests\Inventory\WarehouseStock\MarkDamagedWarehouseStockRequest;
use App\Models\Inventory\Warehouses\WarehouseStock;
use App\Support\ApiMeta;
use App\Support\HttpStatus;
use Illuminate\Http\Request;

class WarehouseStockController extends Controller
{
    public function __construct(
        protected WarehouseStockService $service
    ) {}

    /* =====================
     | LIST STOCK
     |=====================*/
    public function index(Request $request)
    {
        $this->authorize('viewAny', WarehouseStock::class);

        $query = WarehouseStock::query()
            ->with(['warehouse', 'location', 'barang'])
            ->orderBy('updated_at', 'desc');

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        $data = $query->paginate(
            $request->integer('per_page', 20)
        );

        return response()->json([
            'success' => true,
            'message' => 'Data stok warehouse',
            'data'    => new WarehouseStockCollection($data),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    /* =====================
     | INBOUND (RECEIVING)
     |=====================*/
    public function increase(IncreaseWarehouseStockRequest $request)
    {
        $stock = $this->service->increase(
            $request->warehouse_id,
            $request->location_id,
            $request->barang_id,
            $request->jumlah
        );

        return response()->json([
            'success' => true,
            'message' => 'Stok warehouse bertambah',
            'data'    => new WarehouseStockResource($stock),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    /* =====================
     | OUTBOUND (DISPATCH)
     |=====================*/
    public function decrease(DecreaseWarehouseStockRequest $request)
    {
        $stock = $this->service->decrease(
            $request->warehouse_id,
            $request->location_id,
            $request->barang_id,
            $request->jumlah
        );

        return response()->json([
            'success' => true,
            'message' => 'Stok warehouse berkurang',
            'data'    => new WarehouseStockResource($stock),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    /* =====================
     | RESERVE STOCK
     |=====================*/
    public function reserve(ReserveWarehouseStockRequest $request)
    {
        $stock = $this->service->reserve(
            $request->warehouse_id,
            $request->location_id,
            $request->barang_id,
            $request->jumlah
        );

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil di-reserve',
            'data'    => new WarehouseStockResource($stock),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    /* =====================
     | TRANSFER LOCATION
     |=====================*/
    public function transfer(TransferWarehouseStockRequest $request)
    {
        $this->service->transfer(
            $request->warehouse_id,
            $request->from_location_id,
            $request->to_location_id,
            $request->barang_id,
            $request->jumlah
        );

        return response()->json([
            'success' => true,
            'message' => 'Transfer stok antar lokasi berhasil',
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    /* =====================
     | DAMAGED / QC
     |=====================*/
    public function markDamaged(MarkDamagedWarehouseStockRequest $request)
    {
        $stock = $this->service->markDamaged(
            $request->warehouse_id,
            $request->location_id,
            $request->barang_id,
            $request->jumlah
        );

        return response()->json([
            'success' => true,
            'message' => 'Stok ditandai rusak',
            'data'    => new WarehouseStockResource($stock),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
