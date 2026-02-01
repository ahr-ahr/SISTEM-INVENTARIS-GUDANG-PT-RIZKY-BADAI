<?php

namespace App\Http\Controllers\Inventory\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Inventory\WarehouseLocation;
use App\Http\Requests\Inventory\WarehouseLocation\StoreWarehouseLocationRequest;
use App\Http\Requests\Inventory\WarehouseLocation\UpdateWarehouseLocationRequest;
use App\Http\Resources\Inventory\WarehouseLocation\WarehouseLocationResource;
use App\Http\Resources\Inventory\WarehouseLocation\WarehouseLocationCollection;
use App\Support\ApiMeta;
use App\Support\HttpStatus;
use App\Support\HttpMessage;

class WarehouseLocationController extends Controller
{
    public function index()
    {
        $data = WarehouseLocation::query()
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('nama')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new WarehouseLocationCollection($data),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function store(StoreWarehouseLocationRequest $request)
    {
        $location = WarehouseLocation::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::CREATED),
            'data'    => new WarehouseLocationResource($location),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    }

    public function show(WarehouseLocation $warehouseLocation)
    {
        $warehouseLocation->load('children');

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new WarehouseLocationResource($warehouseLocation),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function update(
        UpdateWarehouseLocationRequest $request,
        WarehouseLocation $warehouseLocation
    ) {
        $warehouseLocation->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new WarehouseLocationResource($warehouseLocation->fresh()),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function destroy(WarehouseLocation $warehouseLocation)
    {
        if ($warehouseLocation->children()->exists()) {
            abort(422, 'Location masih memiliki child');
        }

        $warehouseLocation->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Location dinonaktifkan',
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
