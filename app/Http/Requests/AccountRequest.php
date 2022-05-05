<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AccountRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'account_num'=>'required | numeric | unique:accounts,account_num,'.$request->account_id.',account_id',
            'division_id'=>'required | numeric',
            'account_name'=>'required',
        ];
    }

    public  function messages(){
        return[
            'account_num.required'=>'必須項目です。',
            'account_num.numeric'=>'数字でお答えください',
            'account_num.unique'=>'その勘定科目番号は既に登録されています',
            'division_id.required'=>'必須項目です。',
            'division_id.numeric'=>'数字でお答えください。',
            'account_name.required'=>'必須項目です',
        ];
    }
}
