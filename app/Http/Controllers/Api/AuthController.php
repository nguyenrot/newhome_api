<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Dang ky
    public function register(UserRegisterRequest $request){
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        if (!$validated['account_type']){
            $validated['account_type'] = 1;
        }
        $user = User::create($validated);
        return response()->json(["user" => $user, 'msg' => 'Đăng ký thành công'],200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    //Dang nhap
    public function login(UserLoginRequest $request){
        $validated = $request->validated();
        if (auth()->attempt($validated)){
            $user = auth()->user();
            $token = $user->createToken('newHome')->plainTextToken;
            return response()->json(['user' => $user,'token' => $token],200,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['msg' => 'Đăng nhập thất bại'],203,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    //Lay thong tin dang nhap
    public function getCurrentUser(){
        return response()->json([auth()->user(),],200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    //Đăng xuất
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json(['msg' => 'Đăng xuất thành công'],200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
