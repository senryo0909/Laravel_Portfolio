<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//エラーの場合に、FormRequest内でリダイレクトが発生するため、エラ〜メッセージを投げたいならFormRequest::failedValidation()をオーバーライドする
// use Illuminate\Contracts\Validation\Validator;  // 追加
// use Illuminate\Http\Exceptions\HttpResponseException;  // 追加

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
        if(($this->input("column")) == "comments"){
            return [
                'values' => 'nullable|max:20',
            ];
        }
    }

    public function messages()
    {
      if(($this->input("column")) == "comments"){
        
        return [
            'values.max' => ' コメントは20文字以内',
        ];
        }
  }

    // public function response(array $errors)
    // {
    //     if ($this->ajax() || $this->wantsJson()) {
    //         # ここでいじれる
    //         return new JsonResponse(['errors'=>$errors], 422);
    //     }

    //     parent::response($errors);
    // }
    // public function messages()
    // {
    //     return [
    //         'comments.max' => '文字数は最大20字です'
    //     ];
    // }
    // protected function failedValidation( Validator $validator )
    // {
    //     $response['data']    = [];
    //     $response['status']  = 'NG';
    //     $response['summary'] = 'Failed validation.';
    //     $response['errors']  = $validator->errors()->toArray();

    //     throw new HttpResponseException(
    //         response()->json( $response, 422 )
    //     );
    // }
}
