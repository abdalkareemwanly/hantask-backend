<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Role_Permission;
use Exception;

class RoleController extends Controller
{
    public function index()
    {
        $data = [];
        foreach(Role::all() as $role)
        {
            $data[] = [
                'id'    => $role->id,
                'name'  => $role->name,
            ];
        }
        return response()->json([
            'success' => true,
            'mes' => 'All Roles',
            'data' => $data
        ]);
    }
    public function store(RoleRequest $request)
    {
        $data = $request->all();
        $store = Role::create($data);
        if($store) {
            $role = Role::where('name',$store->name)->first();
            $Permissions = Permission::all();
            foreach($Permissions as $Permission) {
                Role_Permission::create([
                    'role_id' => $role->id,
                    'permission_id' => $Permission->id
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'mes' => 'Store Role Successfully',
        ]);
    }
    public function permission(PermissionRequest $request , $id)
    {
        $rolePermissions = Role_Permission::where('role_id', $id)->get();
        $existingPermissionIDs = [];
        foreach ($rolePermissions as $rolePermission) {
            $existingPermissionIDs[] = $rolePermission->permission_id;
        }
        $permissionsToActivate = [];
        foreach ($request->permission as $permissionID) {
            if (!in_array($permissionID, $existingPermissionIDs)) {
                $permissionsToActivate[] = $permissionID;
            }
        }
        Role_Permission::where('role_id', $id)
            ->whereIn('permission_id', $permissionsToActivate)
            ->update(['status' => 1]);
        $permissionsToDeactivate = array_diff($existingPermissionIDs,$request->permission);
        Role_Permission::where('role_id', $id)
            ->where('permission_id', $permissionsToDeactivate)
            ->update(['status' => 0]);
        return response()->json([
            'success' => true,
            'mes' => 'Saving Changes Successfully',
        ]);
    }
}
