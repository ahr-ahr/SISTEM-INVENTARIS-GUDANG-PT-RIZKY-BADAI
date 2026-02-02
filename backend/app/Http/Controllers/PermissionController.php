<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * GET /api/permissions
     */
    public function index()
    {
        $permissions = Permission::with('roles')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data permission',
            'data' => $permissions
        ]);
    }

    /**
     * GET /api/permissions/{id}
     */
    public function show($id)
    {
        $permission = Permission::with('roles')->find($id);

        if (! $permission) {
            return response()->json([
                'status' => false,
                'message' => 'Permission tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail permission',
            'data' => $permission
        ]);
    }
}
