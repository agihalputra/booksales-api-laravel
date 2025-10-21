<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class AuthController extends Controller
{
    public function register(Request $request) {
        //1. Setup validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255|unique:users',
            'password'=> 'required|min:8',
        ]);

        //2. Cek validator
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        //3. Create user
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);

        //4. Cek keberhasilan
        if ($user) {
            return response()->json([
                'success' => true,
                'message'=> 'User created successfully',
                'data' => $user
            ], 201);
        }

        //5. Cek gagal
        return response()->json([
            'success'=> false,
            'message' => 'User created failed'
        ],409); //Conflict
    }

    public function login(Request $request) {
        //1. Setup validator
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email',
            'password'=>['required'],
        ]);
        //2. Cek validator
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        //3. Get kredensial dari request
        $credentials = $request->only('email','password');
        //4. Cek isFailed
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success'=> false,
                'message'=> 'your email or password is incorrect'
            ],401);
        }
        //5. Cek isSucces
        return response()->json([
            'success'=> true,
            'message'=> 'Login successfully',
            'user' => auth()->guard('api')->user(),
            'token'=> $token,
            ], 200);
    }

    public function logout(Request $request) {
        //try
        //1. Invalidate token
        //2. cek isSuccess

        //catch
        //1. cek isFailed

        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success'=> true,
                'message'=> 'Logout successfully'
            ],200);
        } catch (JWTException $e) {
            return response()->json([
                'success'=> false,
                'message' => 'Logout failed!'
            ],500);
        }
    }
}
