<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\User\LoginRequest;
use App\Http\Requests\Site\User\RegisterRequest;
use App\Http\Traits\imageTrait;
use App\Mail\UserMail;
use App\Models\User;
use App\Notifications\UserOtpNotification;
use Exception;
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
        return response()->json([
            'success' => true,
            'mes' => 'Register Successfully',
        ]);
    }
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials',
                ]);
            }
            // Fetch additional user details
            $imagePath = '/uploads/images/users';
            $userDetails = [
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'image' => $imagePath .'/' . $user->image
            ];

            $token = $user->createToken('User Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Successfully',
                'token' => $token,
                'user' => $userDetails,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
