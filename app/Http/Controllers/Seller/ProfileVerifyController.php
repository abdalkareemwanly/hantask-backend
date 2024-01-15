<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\profileVerify\storeRequest;
use App\Http\Traits\imageTrait;
use App\Models\ProfileVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileVerifyController extends Controller
{
    use imageTrait;
    public function store(storeRequest $request)
    {
        $data = $request->validated();
        $data['seller_id'] = Auth::user()->id;
        $data['busines_license'] = $this->saveImage($request->busines_license,'uploads/images/profileVerify/'.Auth::user()->id);
        ProfileVerify::create($data);
        return response()->json([
            'suucess' => true,
            'mes'     => 'Profile Verify Successfully',
        ]);
    }
}
