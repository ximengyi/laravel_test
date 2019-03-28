<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
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

            'id'=> 'required|string',
            'title'=>'required|string|max:10',
            'body'=>'required|string|max:100'

        ];
    }


    public function messages()
    {

        return[
            '*.required' => ':attribute为必填项',
            '*.integer' => ':attribute需为整数',
            '*.string' => ':attribute需为字符串',
        ];

    }
}
