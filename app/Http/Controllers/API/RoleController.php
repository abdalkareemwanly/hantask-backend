<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Role_Permission;
use Exception;
use GuzzleHttp\Psr7\Request;

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
        try
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
        }catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function show($id)
    {
        $data = [];
        $records = Role_Permission::whereHas('role')->whereHas('permission')->whereRelation('role','id',$id)->get();
        foreach($records as $record) {
            $data[] = [
                'id' => $record->id,
                'roleName' => $record->role->name,
                'permissionName' => $record->permission->name,
                'value' => $record->status,

            ];
        }
        return response()->json([
            'success' => true,
            'mes' => "Role Permission",
            'data' => $data
        ]);
    }
    public function permission(PermissionRequest $request , $id)
    {
        $data = [];
        if (!empty($request->permission)) {
            $json_decode = json_decode($request->permission[0]);

            foreach ($json_decode as $element) {
                $data[] = [
                    'id' => $element->id,
                    'value' => $element->value
                ];
            }
            foreach($data as $row) {
                $records = Role_Permission::where('role_id', $id)->where('id',$row['id'])->get();
                foreach ($records as $record) {
                    if($row['value'] == true) {
                        $update = Role_Permission::where('id',$row['id'])->update([
                            'status' => 1
                        ]);
                    } elseif($row['value'] == false) {
                        $update = Role_Permission::where('id',$row['id'])->update([
                            'status' => 0
                        ]);
                    }
                }
            }
        }
        if($update) {
            return response()->json([
                'success' => true,
                'mes' => 'Saving Changes Successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'mes' => 'Error',
            ]);
        }
    }
    public function update(UpdateRoleRequest $request , $id)
    {
        $data = $request->validated();
        $record = Role::find($id);
        $record->update([
            'name' => $request->name ?? $record->name,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Role Successfully',
        ]);
    }
    public function delete($id)
    {
        $record = Role::find($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Deleted Role Successfully',
        ]);
    }
}
