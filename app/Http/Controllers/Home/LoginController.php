<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Session;
use Cookie;
use Validator;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Sms\AliSmsController;
use App\Models\User;
use DB;

class LoginController extends Controller
{
    public function index(){
        $islogin = $this->checkRemember();
        if($islogin)
            return redirect(url('home/person'));
        return view('home.login.index');
    }

    public function register(){
        
        return view('home.login.register');
    }

    public function checkRemember(){

        $cookie = Cookie::get('auth');
        if(isset($cookie)){
            $user = User::where('user_token',$cookie)->first();
            if($user && $user->user_status == 1){
                $this->recordLogin($user->user_id); //添加用户登录信息、更新用户最后登陆的信息
                Session::put('user', $user->toArray());   //user信息放入session
                return true;               
            }else{
                return false;
            }
        }
    }

    public function loginOut(){
        Session::flush();
        Cookie::queue('auth','',-1);//创建cookie
        return redirect(url('home/login'));
    }

    public function doLogin(Request $request){
        $data = $request->except(['_token']);
   
        $user = User::where('user_phone',$data['userPhone'])->orWhere('user_email',$data['userPhone'])->first();

        if(!$user)
        {
            return Redirect::back()->withErrors('该账号不存在');

        }elseif($user->user_status == 2)
        {
            return Redirect::back()->withErrors('该账号已被禁用');

        }elseif(md5($data['userPwd']) != $user->user_pwd)
        {
            return Redirect::back()->withErrors('密码不正确');
            
        }elseif($data['imagecode'] != Session::get('imageCode'))
        {
            return Redirect::back()->withErrors('验证码不正确');
        }else
        {
            $remember = (isset($data['remember_me'])?'true':'false');
            $this->saveRemember($user->user_id,$remember);//判断用户是否记住我,如果是则保存token

            $this->recordLogin($user->user_id); //添加用户登录信息、更新用户最后登陆的信息
            Session::put('user', $user->toArray());   //user信息放入session
            return redirect(url('home/person'));
        }
    }
     //当用户勾选"记住我"
    public function saveRemember($uid,$remember){
        if($remember == false)
            return false;
        //永久登录标识
        $user_token = md5(uniqid(rand(), true));
        
        $res = User::where('user_id',$uid)->update(['user_token'=>$user_token]);
        if($res)
           Cookie::queue('auth', $user_token,60*24*7);//创建cookie
    }

    //添加用户登录信息、更新用户最后登陆的信息
    public function recordLogin($user_id){
        $record = array('login_time'=>date('Y-m-d H:i:s',time()),'user_id'=>$user_id,'login_ip'=>getIp());
        $last = array('user_last_time'=>date('Y-m-d H:i:s',time()),'user_last_ip'=>getIp());

        DB::table('user_login')->insert($record);
        User::where('user_id',$user_id)->update($last);
    }

    
    //注册 
    public function store(Request $request)
    {
        $user_data = $request->except(['_token']);
        $time = date('Y-m-d H:i:s',time()-30*60);
        $rules = [
            'userphone'     => 'unique:user,user_email|unique:user,user_phone',
            'userpwd'       => 'required|confirmed|min:6|max:18',
            'code'          => 'required',
        ];
        $errorMessage = [
            'userphone.unique'      => '该账号已存在',
            'userpwd.required'      => '密码不能为空',
            'userpwd.min'           => '密码长度为6~18位',
            'userpwd.max'           => '密码长度为6~18位',
            'userpwd.confirmed'     => '两次密码不一致',
            'code.required'         => '验证码不能为空',
        ];
        $this->validate($request , $rules , $errorMessage);

        if(preg_match("/^1[34578]{1}\d{9}$/",$user_data['userphone'])){
            $datas['user_phone']=$user_data['userphone'];
            $code = Session::get('phoneCode');
        }elseif(preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/', $user_data['userphone'])){
            $datas['user_email']=$user_data['userphone'];
            $code = Session::get('emailCode');
        }else{
            return Redirect::back()->withErrors('账号格式输入有误！');
        }

        if(!$code){
            return Redirect::back()->withErrors('验证码不为空');
        }elseif($code['code_createtime'] <= $time){
            return Redirect::back()->withErrors('验证码已过期，请重新发送');
        }elseif($code['code_value'] != $user_data['code']){
            return Redirect::back()->withErrors('验证码不正确');
        }
        

        $datas['user_pwd']=md5($user_data['userpwd']);
        $datas['user_type']=1;
        $datas['user_status']=1;
        $datas['user_name']=$user_data['userphone'];
        $users=User::insert($datas);
        if($users){
           return redirect(url('home/login'));
        }else{
            return Redirect::back()->withErrors('系统繁忙，请重新尝试');
        }  
        
    }
    


    public function docode(Request $request){
        $data = array('status'=>-400,'msg'=>'');
        $user = $request->get('userphone');
        $res = DB::table('user')->where('user_phone',$user)->orWhere('user_email',$user)->first();
        if(count($res)>0){
            $data['msg'] = '该手机/邮箱已存在';
        }elseif(preg_match("/^1[34578]{1}\d{9}$/",$user)){  
            $data = $this->doPhoneCodes($user);
        }elseif(preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/', $user)){  
             $data = $this->doEmailCodes($user);
        }else{
            $data['msg'] = '请输出正确的手机或邮箱格式';
        }
       return json_encode($data);
    }

    //发送手机注册验证码
    public function doPhoneCodes($phone){
        $code = array('code_value'=>rand(100000,999999),'user_phone'=>$phone,'code_status'=>1,'code_createtime'=>date('Y-m-d H:i:s',time()),'code_text'=>'手机注册');
        $codes=$code['code_value'];
       
        $sms = new AliSmsController;
        $resp = $sms->doSms($phone,$codes);

        $isset_code=isset($resp->code);
        if($isset_code==false){
            DB::table('code')->insert($code);
            \Session::put('phoneCode', $code);
            return $res = array('status'=>200,'msg'=>'手机验证码发送成功','data'=>$resp);
        }else{
            return $res = array('status'=>-400,'msg'=>'验证码发送失败，请重新尝试');
        }  
    }
    //发送邮箱注册验证码
    public function doEmailCodes($email){
        $code = array('code_value'=>rand(100000,999999),'user_email'=>$email,'code_status'=>2,'code_createtime'=>date('Y-m-d H:i:s',time()),'code_text'=>'邮箱注册');
        date_default_timezone_set('Asia/Shanghai'); 
        $data = ['email'=>$email, 'code'=>$code['code_value']];
        $flag = \Mail::raw('欢迎注册我们的网站，您的验证码为：'.$data['code'].',该验证码有效期为30分钟！',function($message) use($data){
            $message->to($data['email'])->subject('做工程');
        });
    
        DB::table('code')->insert($code);
        \Session::put('emailCode', $code);
        return $res = array('status'=>200,'msg'=>'邮箱验证码发送成功');

       /* if($flag){
            DB::table('code')->insert($code);
            \Session::put('emailCode', $code);
            return $res = array('status'=>200,'msg'=>'邮箱验证码发送成功');
        }else{
            return $res = array('status'=>-400,'msg'=>'邮箱验证发送失败，请重新尝试');
        }*/
    }








    public function create(){}
    public function show(){}
    public function edit(){}
    public function update(Request $request){}
    public function destroy(){}


}
