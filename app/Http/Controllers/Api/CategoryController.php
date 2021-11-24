<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $category;
    function __construct(Category $category)
    {
        $this->category = $category;
    }

    function index(){
        return response()->json($this->category->all(),200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    function get($id){
        $category = $this->category->find($id);
        return response()->json($category ,200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    function patch(Request $request,$id){
        try {
            DB::beginTransaction();
            $data = [
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
            ];
            if ($request->hasFile('image')){
                $path = $request->image->storeAS('public/category', $request->image->getClientOriginalName());
            }
            if (!empty($path)) {
                $data['image'] = Storage::url($path);
            }
            $this->category->find($id)->update($data);
            DB::commit();
            return response()->json(["category" => $this->category->find($id), 'msg' => 'Cập nhập thành công'],200,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $exception){
            DB::rollBack();
            return response()->json(['msg' => 'Cập nhập thất bại'],203,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    function delete($id){
        try{
            DB::beginTransaction();
            $this->category->find($id)->delete();
            DB::commit();
            return response()->json(['msg' => 'Xóa thành công'],200,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $exception){
            DB::rollBack();
            return response()->json(['msg' => 'Xóa thất bại'],203,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    function create(Request $request){
        try {
            DB::beginTransaction();
            $data = [
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
            ];
            if ($request->hasFile('image')){
                $path = $request->image->storeAS('public/category', $request->image->getClientOriginalName());
            }
            if (!empty($path)) {
                $data['image'] = Storage::url($path);
            }
            $category = $this->category->create($data);
            DB::commit();
            return response()->json(["category" => $category, 'msg' => 'Thêm thành công'],200,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $exception){
            DB::rollBack();
            return response()->json(['msg' => 'Thêm thất bại'],203,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

}
