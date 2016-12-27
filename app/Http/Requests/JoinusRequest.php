<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class JoinusRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'   => 'required',
            'details'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '请输入职位名称',
            'details.required' => '请输入职位要求',
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