<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShiftPost extends FormRequest
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
            'user_id' => 'required',
            'column' => 'required',
            'values' => 'required',
            'date' => 'required',
            'id' => 'nullable',
            'comments' => 'nullable'
        ];
    }
    // public function attributes()
    // {
    // return [
    //     'user_id' => 'タスク名',
    //     'column' => 'タスク期限',
    //     'values' => 'タスク詳細',
    //     'date' => '日時',
    //     'id' => '主キー'
    //     ];
    // }
}
