<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * GET /api/employees
     */
    public function index()
    {
        $employees = Employee::with('users')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data employee',
            'data' => $employees
        ]);
    }

    /**
     * GET /api/employees/{id}
     */
    public function show($id)
    {
        $employee = Employee::with('users')->find($id);

        if (! $employee) {
            return response()->json([
                'status' => false,
                'message' => 'Employee tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail employee',
            'data' => $employee
        ]);
    }
}
