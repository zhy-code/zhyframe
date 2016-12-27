<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class FeedbackRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_name'   => 'required',
            'user_email'   => 'required|email',
            'user_phone'   => 'required|numeric',
            'user_content'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => '请输入用户名',
            'user_email.required' => '请输入邮箱',
            'user_phone.required' => '请输入联系方式',
            'user_content.required' => '请输入留言内容',
            'user_email.email' => '邮箱格式不正确',
            'user_phone.numeric' => '手机号格式不正确',
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