<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * GET /api/users
     */
    public function index()
    {
        $users = User::with(['employee', 'role'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data users',
            'data' => $users
        ]);
    }

    /**
     * GET /api/users/{id}
     */
    public function show($id)
    {
        $user = User::with(['employee', 'role'])->find($id);

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail user',
            'data' => $user
        ]);
    }
}
