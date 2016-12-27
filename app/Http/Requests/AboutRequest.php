<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class AboutRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '请输入标题',
        ];
    }

    public function response(array $errors)
    {
        $jsonData = [
            'status'  => '0',
            'message' => current($errors)[0],
        ];
        return response()->json($jsonData);
    }
}