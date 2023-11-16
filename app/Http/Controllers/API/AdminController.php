<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Role_Permission;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminNumber()
    {
        return Admin::pluck('id')->count();
    }

    public function login(AdminRequest $request)
    {

        try {
            $data = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            $admin = Admin::where('email', $request->email)->first();

            if (!$admin || !Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials',
                ]);
            }
            $permission = [];
            foreach(Role_Permission::whereHas('role')->whereHas('permisision')->get() as $rolePermission) {
                $permission[] = [
                    'id' => $rolePermission->id,
                    'permisisionName' => $rolePermission->permisision->name,
                ];
            }
            // Fetch additional admin details
            $adminDetails = [
                'username' => $admin->username,
                'email' => $admin->email,
                'role' => $admin->role,
                'permission' => $permission
            ];

            $token = $admin->createToken('Admin Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Successfully',
                'token' => $token,
                'admin' => $adminDetails,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
