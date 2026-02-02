<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * GET /api/roles
     */
    public function index()
    {
        $roles = Role::with(['permissions', 'users'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Data role',
            'data' => $roles
        ]);
    }

    /**
     * GET /api/roles/{id}
     */
    public function show($id)
    {
        $role = Role::with(['permissions', 'users'])->find($id);

        if (! $role) {
            return response()->json([
                'status' => false,
                'message' => 'Role tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail role',
            'data' => $role
        ]);
    }
}
