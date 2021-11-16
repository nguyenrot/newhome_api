<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    //Dang ky
    public function register(UserRegisterRequest $resquest){
        $validated = $resquest->validated();
        $user = User::create($validated);
        return response()->json(["user" => $user, 'msg' => 'Đăng ký thành công'],200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    //Dang nhap
    public function login(){

    }
    //Lay thong tin dang nhap
}
