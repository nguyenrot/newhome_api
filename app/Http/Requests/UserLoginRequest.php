<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'bail|required|min:10|max:255',
            'password' => 'bail|required|min:8|max:32',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Không được để trống',
            'email.min'=>'Emai phải có ít nhất 10 ký tự',
            'password.min'=>'Mật khẩu phải có ít nhất 8 ký tự',
            'email.max'=>'Email tối đa 255 ký tự',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([$validator->errors()],422, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE));
    }
}
