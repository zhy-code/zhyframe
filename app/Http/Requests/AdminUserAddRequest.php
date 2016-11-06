<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminUserAddRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_name'         => 'required|unique:admin_user,user_name',
            'user_true_name'     => 'required',
            'user_password'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => '请输入登陆账号',
            'user_name.unique' => '登陆账号已存在，请重设',
			'user_true_name.required' => '请输入管理员名称',
            'user_password.required' => '请输入密码',
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