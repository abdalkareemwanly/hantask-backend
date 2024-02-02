<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\User\LoginRequest;
use App\Http\Requests\Site\User\RegisterRequest;
use App\Http\Traits\imageTrait;
use App\Models\User;
use App\Notifications\UserOtpNotification;
use Exception;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Verified;
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
        if(isset($request->image)) {
            $data['image'] = $this->saveImage($data['image'], 'uploads/images/users');
            $user = User::create($data);
            return response()->json([
                'success' => true,
                'mes' => 'Register Successfully',
            ]);
        } else {
            $user = User::create($data);
            return response()->json([
                'success' => true,
                'mes' => 'Register Successfully',
            ]);
        }
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
            if($user->user_status ==1 && $user->account_state == 1)
            { 
              $imagePath = '/uploads/images/users';
              if($user['user_type'] == 1) {
                $type = 'buyer';
              } else {
                $type = 'seller';
              }
              $userDetails = [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'image' => $imagePath .'/' . $user->image,
                'user_type' => $type
            ];

            $token = $user->createToken('User Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Successfully',
                'token' => $token,
                'user' => $userDetails,
            ]);
          } else {
             return response()->json([
                'success' => false,
                'message' => 'Login Error The account must be activated',
            ]);
          }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
