<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Config;
use Redirect;
use Session;
use DB;
use Route;
use App\Model\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
class AuthController extends Controller
{
    /*
     * 列表
     */
    public function index() {
        return view('admin.auth.login');
    }


    /*
     * 验证用户登录
     */
    public function checkLogin(Request $request) {
        $errors = [];
        $data = $request->except(['_token']);
        $code = \Session::get('imageCode');
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'code' => 'required',
        ];
        $errorMessage = [
            'username.required' => '密码不能为空',
            'password.required' => '密码不能为空',
            'code.required' => '密码不能为空',
        ];
        $this->validate($request , $rules , $errorMessage);
        if ($code != $data['code'])   $errors['code'] =  '验证码不正确';
        $user = Admin::where('name', $data['username'])->first();
        if (count($user) == 0)
        {
            $errors['username'] =  '用户名不存在';
        }else
        {
            if (!Hash::check($data['password'] , $user->password)) $errors['password'] =  '密码不正确';
        }
        if (count($errors) > 0)
        {
            return back()->withInput($data)->withErrors($errors);
        }
        session(['admin' => $user]);
        return redirect('admin');
    }


    //退出登录
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('admin/login');
    }

}