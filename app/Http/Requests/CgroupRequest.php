<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class CgroupRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'   => 'required',
            'subtitle'   => 'required',
			'title_pic'   => 'required',
            'classify'   => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '请输入旗下公司名称',
            'subtitle.required' => '请输入旗下公司简称',
			'title_pic.required' => '封面图不得为空',
            'classify.numeric' => '请选择链接类别',
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