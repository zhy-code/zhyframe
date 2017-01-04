<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class SortGoodsShopRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sortgoodsshop_name'         => 'required',
            'sortgoodsshop_parent_id'    => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'sortgoodsshop_name.required' => '请输入分类名称',
			'sortgoodsshop_parent_id.numeric' => '请选择分类归属',
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