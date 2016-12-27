<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminMenuRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'menu_name'         => 'required',
            'menu_parent_id'    => 'numeric',
            'menu_module'       => 'required',
            'menu_controller'   => 'required',
            'menu_action'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'menu_name.required' => '请输入菜单名称',
			'menu_parent_id.numeric' => '请选择菜单归属',
            'menu_module.required' => '请输入模块名称',
            'menu_controller.required' => '请输入控制器名称',
            'menu_action.required' => '请输入操作方法名称',
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