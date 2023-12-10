<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\PaginatRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\storeRequest;
use App\Http\Resources\AdminResource;
use App\Http\Traits\imageTrait;
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
    use imageTrait;
    public function AdminNumber()
    {
        return Admin::pluck('id')->count();
    }

    public function login(AdminRequest $request)
    {

        try {
            $admin = Admin::where('email', $request->email)->first();

            if (!$admin || !Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials',
                ]);
            }
            $permission = [];
            foreach(Role_Permission::whereHas('role')->whereHas('permission')->whereRelation('role','name',$admin->role)->where('status',1)->get() as $rolePermission) {
                $permission[] = [
                    'id' => $rolePermission->id,
                    'permissionName' => $rolePermission->permission->name,
                    'permissionStatus' => $rolePermission->status
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
    public function all(PaginatRequest $request)
    {
        if(isset($request->search)) {
            $paginate = Admin::where('name' , $request->search)->orWhere('username' , $request->search)->paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'username' => $admin->username,
                    'email' => $admin->email,
                    'role' => $admin->role,
                    'image' => '/uploads/images/admins/' . $admin->image,
                ];
            });
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $data,
                'next_page_url' => $nextPageUrl,
                'total' => $paginate->count(),
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
            ]);
        }
        if($request->paginate) {
            $paginate = Admin::paginate($request->paginate);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'username' => $admin->username,
                    'email' => $admin->email,
                    'role' => $admin->role,
                    'image' => '/uploads/images/admins/' . $admin->image,
                ];
            });
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $data,
                'next_page_url' => $nextPageUrl,
                'total' => $paginate->count(),
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
            ]);
        } else {
            $paginate = Admin::paginate(10);
            $nextPageUrl = $paginate->nextPageUrl();
            $data = $paginate->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'username' => $admin->username,
                    'email' => $admin->email,
                    'role' => $admin->role,
                    'image' => '/uploads/images/admins/' . $admin->image,
                ];
            });
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $data,
                'next_page_url' => $nextPageUrl,
                'total' => $paginate->count(),
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
            ]);
        }

    }
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        $data['image'] = $this->saveImage($request->image,'uploads/images/admins');
        Admin::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Store Admin Successfully',
        ]);
    }

}
