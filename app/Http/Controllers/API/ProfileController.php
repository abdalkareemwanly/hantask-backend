<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChange;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Admin::where('id',Auth::user()->id)->first();
        return response()->json([
            'success' => true,
            'mes' => 'All ServiceCity',
            'data' => [
                [
                    'id'            => $admin->id,
                    'name'          => $admin->name,
                    'username'      => $admin->username,
                    'email'         => $admin->email,
                    'role'          => $admin->role,
                ]
            ]
        ]);
    }
    public function update(ProfileRequest $request)
    {
        $record = Admin::find(Auth::user()->id);
        $record->update([
            'name'                  => $request->name ?? $record->name,
            'email'                 => $request->email ?? $record->email,
            'username'              => $request->username ?? $record->username,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Admin Successfully',
        ]);
    }
    public function password_change(PasswordChange $request)
    {
        $hashPassword = Hash::make($request->password);
        $admin = Admin::find(Auth::user()->id);
        $admin->update([
            'password' => $hashPassword
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Password Successfully',
        ]);
    }
    public function logout()
    {
        $admin = Admin::find(Auth::user()->id);
        $admin->tokens()->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Logout Successfully',
        ]);
    }
}
