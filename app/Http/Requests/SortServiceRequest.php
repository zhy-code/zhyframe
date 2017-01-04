<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class SortServiceRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sortservice_name'         => 'required',
            'sortservice_parent_id'    => 'numeric',
            'sortservice_shop_id'    => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'sortservice_name.required' => '请输入分类名称',
			'sortservice_parent_id.numeric' => '请选择分类归属',
			'sortservice_shop_id.numeric' => '请选择归属商铺类别',
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