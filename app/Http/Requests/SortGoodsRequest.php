<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class SortGoodsRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sortgoods_name'         => 'required',
            'sortgoods_parent_id'    => 'numeric',
            'sortgoods_shop_id'    => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'sortgoods_name.required' => '请输入分类名称',
			'sortgoods_parent_id.numeric' => '请选择分类归属',
			'sortgoods_shop_id.numeric' => '请选择归属商铺类别',
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