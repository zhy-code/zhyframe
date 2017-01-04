<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Gregwar\Captcha\CaptchaBuilder;

class PublicController
{
    /**
     * 验证码
     */
    public function code() {
        $builder = new CaptchaBuilder;

        $builder->build();

        $builder->buildAgainstOCR(150, 40);

        $response = \Response::make( $builder->output() );

        $response->header('Content-Type', 'image/png');

        \Session::put('imageCode', $builder->getPhrase());

        return $response;
    }



    /**
     * 发送邮箱
     */
   /* public function sendEmail(Request $request)
    {
        $code = substr(mt_rand(), 1, 4);
        $data = ['email'=>$request->get('email'), 'code' => $code];
        \Session::put('emailCode', $code);
        \Mail::send('activemail', $data, function($message) use($data)
        {
            $message->to($data['email'], '优品商家注册')->subject('优品！');
        });
        return response()->json(['state' => 200]);
    }*/

    /**
     * 上传图片
     */
    public function uploadImg(Request $request)
    {
        // return response()->json(['state' => 0, 'message' => $request->all() ]);
        // if (!$request->hasFile('image')) {
        //     return response()->json(['state' => 0, 'message' => '上传文件为空!']);
        // }
        include 'Controller.php';
        $con = new controller();
        $file = $request->file("image");
        // if(!$file->isValid()){
        //     return response()->json(['state' => 0, 'message' => '上传文件出错!']);
        // }
        
        $path = $con->setImageUrl();//获取七牛云图片显示地址前缀
        $url = Config::get('cloudsystem.UPLOAD_URL');
        $code = $request->get('code');

        if ( !isset($url[ $code ]) ) {
            return response()->json(['state' => 0, 'message' => '上传参数错误!']);
        }

        $inNewName = array();

        if ( is_object($file) && count($file) == 1 ) {
            $isArray = 1;
            $originalName = $file->getFileName();
            $extension = $file->getClientOriginalExtension(); //上传文件的后缀.
            $newName = md5Rturn() . '.' . $extension;
            $inNewName[] = $newName;
            $size = $file->getSize();
            // $path = $url[$code] . substr($newName, 0, 1).'/';
            // $urlArray[] = '/'.$path.$newName;
            $urlArray[] = $path.'/'.$newName;
            //$file->move($path, $newName)
            //图片保存至七牛
            if ( ! $con->Uploade($newName,$file->getRealPath())) {
                $file->move($url[ $code ], $newName);//本地服务器备份
                return response()->json(['state' => 0, 'message' => '保存文件失败！']);
            }

        } else if ( count($file) >= 1 ) {
            if (count($file) > 8) {
                return response()->json(['state' => 0, 'message' => '最多只允许上传8张！']);
            }
            $isArray = 2;
            foreach ($file as $key => $value) {
                $originalName[] = $value->getFileName();
                $extension = $value->getClientOriginalExtension(); //上传文件的后缀.
                $newName = md5Rturn() . '.' . $extension;
                $inNewName[] = $newName;
                $size = $value->getSize();
                // $path = $url[$code] . substr($newName, 0, 1).'/';
                // $urlArray[] = '/'.$path.$newName;
                $urlArray[] = $path.'/'.$newName;
                if ( !$con->Uploade($newName,$value->getRealPath()) ) {
                    $file->move($url[ $code ], $newName);//本地服务器备份
                    return response()->json(['state' => 0, 'message' => '保存文件失败！']);
                }
            }
            
        } else {
            return response()->json(['state' => 0, 'message' => '上传文件为空!']);
        }

        // $extension = $file->getClientOriginalExtension(); //上传文件的后缀.
        // $newName = md5Rturn() . '.' . $extension;
        // $size = $file->getSize();
        // $path = $url[$code] . substr($newName, 0, 1).'/';
        // if ( !$file->move($path, $newName) ) {
        //     return response()->json(['state' => 0, 'message' => '保存文件失败！']);
        // }
        

        if ( $code == 'goods' && $request->get('store_id') ) {
            if ( count($inNewName) > 0 ) {
                foreach ($inNewName as $v) {
                    $data[] = array(
                        'shop_id' => $request->get('store_id'),
                        'goods_id' => $request->get('goods_id'),
                        'image' => $v
                    );
                }
                GoodsImages::insert( $data );
            }
        }

        $info = array(
            'is_array' => $isArray,
            'originalName' => $originalName,
            'name' => $inNewName,
            'url' => $urlArray,
            'size' => $size,
            'type' => $extension,
            'state' => 'SUCCESS'
        );

       return response()->json(['data' => $info, 'state' => '200']);
    }

}
