<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
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
            'asset_type_id'=>'numeric | required',
            'asset_name'=>'required',
            'balance'=>'required | numeric',
        ];
    }

    public function messages(){
        return [
            'asset_type_id.required'=>'必須項目です。',
            'asset_tpe_id.numeric'=>'数字でお答えください',
            'asset_name.required'=>'必須項目です',
            'balance.required'=>'必須項目です',
            'balance.numeric'=>'数字でお答えください',
        ];
    }
}
