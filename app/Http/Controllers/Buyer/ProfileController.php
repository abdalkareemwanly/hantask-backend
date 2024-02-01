<?php

namespace App\Http\Controllers\Buyer;

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
        $buyer = User::whereHas('country')->whereHas('city')
                ->whereHas('area')->where('id',Auth::user()->id)->where('user_type','1')->first();
        $imagePath = '/uploads/images/users';
        $data[] = [
            'id' => $buyer->id,
            'name' => $buyer->name,
            'username' => $buyer->username,
            'email' => $buyer->email,
            'phone' => $buyer->phone,
            'image' => $imagePath .'/' . $buyer->image,
            'country' => [
                'id'   => $buyer->country->id,
                'name' => $buyer->country->country,
            ],
            'city' => [
                'id'   => $buyer->city->id,
                'name' => $buyer->city->service_city,
            ],
            'area' => [
                'id'   => $buyer->area->id,
                'name' => $buyer->area->service_area,
            ],
        ];
        return response()->json([
            'mes'     => 'success',
            'data'    => $data,
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
            'country_id'    => $request->country_id ?? $record->country_id,
            'service_city'  => $request->service_city ?? $record->service_city,
            'service_area'  => $request->service_area ?? $record->service_area,
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
