<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class NewsRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'   => 'required',
            'title_pic'   => 'required',
            'classify'   => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '请输入新闻标题',
            'title_pic.required' => '新闻封面图不得为空',
            'classify.numeric' => '请选择新闻类别',
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