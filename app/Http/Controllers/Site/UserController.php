<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\User\RegisterRequest;
use App\Http\Traits\imageTrait;
use App\Mail\UserMail;
use App\Models\User;
use App\Notifications\UserOtpNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use imageTrait;
    public function __construct()
    {
        $this->otp = new Otp;
    }
    private $otp;

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['image'] = $this->saveImage($data['image'], 'uploads/images/users');
        $store = User::create($data);
        if($store) {
            $notify = $store->notify(new UserOtpNotification);
        }
        return response()->json([
            'success' => true,
            'mes' => 'Store User Successfully',
        ]);
    }
}
