<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
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
            'use_date' => 'required | date',
            'withdrawal_date' => 'required | date',
            'account_id' => 'required | numeric',
            'asset_id' => 'required | numeric',
            'amount' => 'required | numeric',
            'log_note' => 'required',
        ];
    }

    public function messages(){
        return [
            'use_date.required' => '必須項目です。',
            'use_date.date' => '日付でご入力ください。',
            'withdrawal_date.required' => '必須項目です。',
            'withdrawal_date.date' => '日付でご入力ください。',
            'account_id.required' => '必須項目です。',
            'account_id.numeric' => '数字でご入力ください。',
            'asset_id.required' => '必須項目です。',
            'asset_id.numeric' => '数字でご入力ください。',
            'amount.required' => '必須項目です。',
            'amount.numeric' => '数字でご入力ください。', 
            'log_note.required' => '必須項目です',  
        ];

    }
}
