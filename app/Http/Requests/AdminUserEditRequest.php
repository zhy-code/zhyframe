<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminUserEditRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_true_name'     => 'required',
        ];
    }

    public function messages()
    {
        return [
			'user_true_name.required' => '请输入管理员名称',
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