<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class SortServiceShopRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sortserviceshop_name'         => 'required',
            'sortserviceshop_parent_id'    => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'sortserviceshop_name.required' => '请输入分类名称',
			'sortserviceshop_parent_id.numeric' => '请选择分类归属',
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