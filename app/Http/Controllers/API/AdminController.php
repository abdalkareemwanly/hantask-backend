<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(AdminRequest $request)
    {
        try {
                $admin = Admin::where('email',$request->email)->first();
                if( Hash::check($request->password , $admin->password)) {
                    $token = $admin->createToken('Admin Token')->plainTextToken;
                    return response()->json([
                            'success' => true,
                            'mes' => 'Login Successfully',
                            'token' => $token
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'mes' => 'Error',
                        ]);
                    }
                } catch(Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                    ]);
            }
    }

}
