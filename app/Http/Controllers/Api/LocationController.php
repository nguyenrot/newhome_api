<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Sodium\add;


class LocationController extends Controller
{
    public function index(){
        $citys = Storage::get('public/location.json');
        return $citys;
    }

    public function city_id($id){
        if (!empty($this->get_districts($id)))
            return json_encode($this->get_districts($id),JSON_UNESCAPED_UNICODE);
        $json_string =
        '
            {
                "type": "about:blank",
                "title": "Not Found",
                "status": 404,
                "detail": "Not Found"
            }
        ';
        return json_decode($json_string);
    }

    public function district_id($id_city,$id){
        $json_string =
            '
            {
                "type": "about:blank",
                "title": "Not Found",
                "status": 404,
                "detail": "Not Found"
            }
        ';
        $object_district = $this->get_districts($id_city);
        foreach ($object_district as $item) {
            if ($item['code'] == $id) {
                $wards = Storage::get('public/ward.json');
                $object_wards = json_decode($wards, true);
                $list_wards = array();
                foreach ($object_wards as $item) {
                    if ($item['district_code'] == $id)
                        $list_wards[] = $item;
                }
                if (!empty($list_wards))
                    return json_encode($list_wards,JSON_UNESCAPED_UNICODE );
                return json_decode($json_string);
            }
        }
        return json_decode($json_string);
    }
    public function get_districts($id){
        $districts = Storage::get('public/district.json');
        $object_district = json_decode($districts,true);
        $list_districts = array();
        foreach ($object_district as $item){
            if ($item['province_code']==$id)
                $list_districts[] = $item;
        }
        return $list_districts;
    }
}
