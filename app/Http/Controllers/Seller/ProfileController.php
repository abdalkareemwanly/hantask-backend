<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\ChangePasswordRequest;
use App\Http\Requests\Buyer\ProfileEditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $data = [];
        $seller = User::where('id',Auth::user()->id)->first();
        $imagePath = '/uploads/images/users';
        $data[] = [
            'id' => $seller['id'],
            'name' => $seller['name'],
            'username' => $seller['username'],
            'email' => $seller['email'],
            'phone' => $seller['phone'],
            'image' => $imagePath .'/' . $seller['image']
        ];
        return response()->json([
            'mes' => 'success',
            'data' => $data
        ]);
    }
    public function update(ProfileEditRequest $request)
    {
        $record = User::where('id',Auth::user()->id)->first();
        if(request()->hasFile('image')) {
            File::delete('uploads/images/users/'.$record->image);
        }
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($request->image,'uploads/images/users');
        }
        $record->update([
            'name'          => $request->name ?? $record->name,
            'email'         => $request->email ?? $record->email,
            'username'      => $request->username ?? $record->username,
            'phone'         => $request->phone ?? $record->phone,
            'image'         => $data['image'] ?? $record->image,
        ]);
        return response()->json([
            'success' => true,
            'mes' => 'Update Profile Successfully',
        ]);
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::where('id',Auth::user()->id)->first();
        $hashPassword = Hash::make($request->password);
        $user->update(['password' => $hashPassword]);
        $user->tokens()->delete();
        return response()->json([
            'success' => true,
            'mes' => 'Update Password Successfully',
        ]);
    }
}
