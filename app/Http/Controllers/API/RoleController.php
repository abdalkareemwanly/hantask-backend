<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'success' => true,
            'mes' => 'All Roles',
            'roles' => $roles
        ]);
    }
    public function store(RoleRequest $request)
    {
        try {
                DB::beginTransaction();
                $role = Role::create(['name' => $request->name,'guard_name' => 'api']);
                $role->syncPermissions($request->permission);
                return response()->json([
                    'success' => true,
                    'mes' => 'Store Role Successfully',
                ]);
                DB::commit();
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
                DB::rollback();
            }
    }
}
