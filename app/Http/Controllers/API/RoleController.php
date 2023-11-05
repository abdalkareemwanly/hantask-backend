<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\UpdateRoleRequest;
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
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions([$request->permission],Auth::guard('sanctum'));
        return response()->json([
            'success' => true,
            'mes' => 'Store Role Successfully',
        ]);

        return response()->json([
            'success' => false,
            'message' => 'error',
        ]);
    }
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();
        return response()->json([
            'success' => true,
            'mes' => 'Show Role Successfully',
            'data' => [
                $role , $rolePermissions
            ]
        ]);
    }
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return response()->json([
            'success' => true,
            'mes' => 'Update Role Successfully',
        ]);
    }
    public function delete($id)
    {
        $delete = Role::find($id);
        $delete->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Delete Role Successfully',
        ]);
    }
}
