<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(UserRequest $request)
    {
        // $user = User::where('email',$request->email)->first();
        // if(Hash::check($request->password , $user->password)) {
        //     $token = $user->createToken('Laravel Password Grant Client')->plainTextToken;
        //     return response()->json([
        //         'mes' => 'Login Successfully',
        //         'token' => $token
        //     ]);
        // } else {
        //     return response()->json([
        //         'mes' => 'Error',
        //     ]);
        // }
        // return response()->json($request);
    }
}
