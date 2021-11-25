<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserInformationController extends Controller
{
    private $userInformation;
    private $User;
    public function __construct(UserInformation $userInformation, User $User)
    {
        $this->userInformation = $userInformation;
        $this->User = $User;
    }

    public function get_infor_user($id){
        return $this->userInformation->where('user_id',$id)->get();
    }

    public function get($id){
        return $this->userInformation->find($id);
    }

    public function post(Request $request){
        try {
            DB::beginTransaction();
            $s = 'content';
            $data = [
                'user_id'=>Auth()->user()->id,
                'title'=>$request->title,
                'content'=>$request->$s,
            ];
            $userInformation = $this->userInformation->create($data);
            DB::commit();
            return response()->json(["category" => $userInformation, 'msg' => 'Thêm thành công'],200,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $exception){
            Log::error('Message'.$exception->getMessage().'Line : '.$exception->getLine());
            DB::rollBack();
            return response()->json(['msg' => 'Thêm thất bại'],203,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function patch(Request $request, $id){
        try{
            DB::beginTransaction();
            $userInformation = $this->userInformation->find($id);
            if ($userInformation->user_id!=Auth()->user()->id)
                return response()->json(['msg' => 'Cập nhập thất bại'],203,
                    ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            $s = 'content';
            $userInformation->update($request->all());
            DB::commit();
            return response()->json(["category" => $this->userInformation->find($id), 'msg' => 'Thêm thành công'],200,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error('Message'.$exception->getMessage().'Line : '.$exception->getLine());
            return response()->json(['msg' => 'Cập nhập thất bại'],203,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function delete(Request $request, $id){
        try{
            DB::beginTransaction();
            $userInformation = $this->userInformation->find($id);
            if ($userInformation->user_id!=Auth()->user()->id)
                return response()->json(['msg' => 'Xóa thất bại'],203,
                    ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            $userInformation->delete();
            DB::commit();
            return response()->json(['msg' => 'Xóa thành công'],200,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $exception){
            DB::rollBack();
            return response()->json(['msg' => 'Xóa thất bại'],203,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }
}
