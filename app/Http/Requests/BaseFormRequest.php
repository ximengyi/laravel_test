<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class BaseFormRequest extends FormRequest
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
    // protected function failedValidation(Validator $validator)
    // {
    //     throw (new HttpResponseException(response()->json([
    //         'code'=>200,
    //         'msg'=>$validator->errors(),
    //         'data'=>null
    //     ],200)));
    // }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw (new ValidationException($validator))
    //         ->errorBag($this->errorBag)
    //         ->redirectTo($this->getRedirectUrl());
    // }

    protected function failedValidation(Validator $validator)
    {

        $error= $validator->errors()->all();
        throw new HttpResponseException(response()->json(['msg'=>'error','code'=>'500','data'=>$error[0]], 500));

    }



}
