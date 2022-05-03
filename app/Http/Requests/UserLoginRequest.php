<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
                'email'=>'email | required',
                'password'=>'required | alpha-num | min:4'            
        ];
    }

    public function messages(){
        return [
            'email.email' => 'メールアドレスを入力してください',
            'email.required' => 'メールアドレスは必ず入力してください',
            'password.required' => 'パスワードは必ず入力してください',
            'password.alpha-num' => ' パスワードはアルファベットか数字でご登録ください',
            'password.min'=>'パスワードは4文字以上でご登録ください'
    ];
    }
}
