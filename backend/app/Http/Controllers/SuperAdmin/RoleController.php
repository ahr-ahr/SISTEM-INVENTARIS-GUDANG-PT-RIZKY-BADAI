<?php

namespace App\Http\Controllers\SuperAdmin;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        return response()->json([
            'success' => true,
            'message' => 'Data Role',
            'data'    => new RoleCollection(
                Role::orderBy('name')
                    ->paginate($request->integer('per_page', 20))
            ),
            'meta' => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}

?>