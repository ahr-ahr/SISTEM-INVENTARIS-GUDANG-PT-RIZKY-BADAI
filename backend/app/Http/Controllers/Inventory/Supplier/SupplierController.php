<?php

namespace App\Http\Controllers\Inventory\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Supplier;
use App\Http\Requests\Inventory\Supplier\StoreSupplierRequest;
use App\Http\Requests\Inventory\Supplier\UpdateSupplierRequest;
use App\Http\Resources\Inventory\Supplier\SupplierResource;
use App\Http\Resources\Inventory\Supplier\SupplierCollection;
use App\Support\ApiMeta;
use App\Support\HttpMessage;
use App\Support\HttpStatus;

class SupplierController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Supplier::class);

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new SupplierCollection(
                Supplier::orderBy('nama')->get()
            ),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function store(StoreSupplierRequest $request)
    {
        $supplier = Supplier::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::CREATED),
            'data'    => new SupplierResource($supplier),
        ], HttpStatus::CREATED);
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new SupplierResource($supplier),
        ], HttpStatus::OK);
    }

    public function destroy(Supplier $supplier)
    {
        $this->authorize('delete', $supplier);

        $supplier->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil dinonaktifkan',
        ], HttpStatus::OK);
    }
}
