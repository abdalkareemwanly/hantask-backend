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
            $data = $request->validated();
            $store = Role::create($data);
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
        if (!empty($request->id)) {
            foreach ($request->id as $ID) {
                $data[] = $ID;
            }
            $json_decode = json_decode($ID);
            $records = Role_Permission::where('role_id', $id)->whereIn('id', $json_decode)->get();
            foreach ($records as $record) {
                $status = $record->status === 1 ? 0 : 1;
                $record->update(['status' => $status]);
            }
        }
        return response()->json([
            'success' => true,
            'mes' => 'Saving Changes Successfully',
        ]);
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
