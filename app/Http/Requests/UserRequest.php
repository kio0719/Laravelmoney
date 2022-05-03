<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                'name'=>'required',
                'email'=>'email | required|unique:users',
                'password'=>'required | alpha-num | confirmed | min:4'            
        ];
    }

    public function messages(){
        return [
            'name.required' => '名前は必ず入力してください',
            'email.email' => 'メールアドレスを入力してください',
            'email.required' => 'メールアドレスは必ず入力してください',
            'email.unique' => 'そのメールアドレスは既に登録されています',
            'password.required' => 'パスワードは必ず入力してください',
            'password.alpha-num' => ' パスワードはアルファベットか数字でご登録ください',
            'password.confirm' => 'パスワードが一致していません',
            'password.min'=>'パスワードは4文字以上でご登録ください'
    ];
    }
}
