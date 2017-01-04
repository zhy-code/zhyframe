<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use DB;

use App\Model\SortDemand;
use App\Model\AreaProvice;
use App\Model\User;

class UserController extends Controller
{

    public function index()
    {

        return view('home.user.index');
    }
    //个人身份验证
    public function validation(){

        return view('home.user.validation');
    }
    //个体身份验证
    public function validationper(){

        return view('home.user.validationper');
    }
    //民企身份验证
    public function validationmin(){

        return view('home.user.validationmin');
    }
    //国企身份验证
    public function validationguo(){

        return view('home.user.validationguo');
    }
    //升级VIP
    public function upgrade(){

        return view('home.user.upgrade');
    }
    //开通商铺
    public function openshop(){

        return view('home.user.openshop');
    }
    //缴纳保证金
    public function paydeposit(){

        return view('home.user.paydeposit');
    }
    //商品订单
    public function orders(){

        return view('home.user.orders');
    }
    //服务订单
    public function serorders(){
        
        return view('home.user.serorders');
    }

    //退款
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //ajax图片上传
    public function uploadImg(Request $request){
        $data = array('status'=>-200,'msg'=>'文件上传出错！');
        $name = $request->get('name');
        $pathname = $request->get('pathname');
        if ($request->hasFile($name)) {
            $fileName = date('YmdHis',time()).uniqid().'.'.$request->file($name)->getClientOriginalExtension();
            if ($request->file($name)->move('images/'.$pathname.'/', $fileName))
                $imgsrc = '/images/'.$pathname.'/'. $fileName;
                $data = array('status'=>200,'data'=>$imgsrc,'msg'=>'上传成功');
        }
        return $data;
    }
    //收货地址列表
    public function TakeAddress(){
        $info = \Session::get('user');
        $arealist = Area::where('area_parent_id',0)->orderBy('area_sort','desc')->orderBy('area_id','asc')->get();
        $takelist = Takeaddress::where('user_id',$info['user_id'])
        ->with('take_area_p')->with('take_area_c')->with('take_area_x')->with('take_area_t')
        ->orderBy('take_isdefault','desc')
        ->get();
        $takecount =  count($takelist);
        return view('home.user.takeaddress',compact('arealist','takelist','takecount'));
    }
    //删除收货地址
    public function delTakeAddress(Request $request,$id){
        $data = array('status'=>-200,'msg'=>'系统出现错误，请稍后尝试放！');
        $res = Takeaddress::destroy($id);
        if($res){
            $data = array('status'=>200,'msg'=>'删除成功');
        }
        return $data;
    }
    //新增收货地址
    public function createTakeAddress(Request $request){
        $data = $request->except(['_token']);
        $info = \Session::get('user');

        if(Takeaddress::where('user_id',$info['user_id'])->count() >= 10 )
        {
            return Redirect::back()->withErrors('创建失败，收货地址最多创建10条！');
        }

        $data['user_id'] = $info['user_id'];
        $rules = [
            'take_name'       => 'required',
            'take_phone'      => 'required',
            'take_area_1'     => 'required',
            'take_area_2'     => 'required',
            'take_area_3'     => 'required',
            'take_area_desc'  => 'required',
            'take_area_code'  => 'required|regex:/^[1-9][0-9]{5}$/',
        ];
        $errorMessage = [
            'take_name.required'      => '收货人姓名不能为空！',
            'take_phone.required'     => '联系电话不能为空！',
            'take_area_1.required'    => '省/直辖市不能为空！',
            'take_area_2.required'    => '市不能为空！',
            'take_area_3.required'    => '区/县不能为空！',
            'take_area_desc.required' => '详细地址不能为空！',
            'take_area_code.required' => '邮政编码不能为空！',
            'take_area_code.regex'    => '邮政编码格式不正确！',
        ];
        $this->validate($request,$rules,$errorMessage);

        //修改默认地址
        if($data['take_isdefault'] == 1)
        {
            Takeaddress::where('user_id',$info['user_id'])->update(['take_isdefault'=>0]);
        }
        //添加新地址
        $res = Takeaddress::create($data);
        if(!$res->count())
        {
            return Redirect::back()->withErrors('系统出现错误，请稍后尝试！');
        }
        return redirect(url('home/takeaddress'));
    }
    //收货地址详细
    public function takeAddressInfo($id){
        $arealist = Area::where('area_parent_id',0)->orderBy('area_sort','desc')->orderBy('area_id','asc')->get();
        $take = Takeaddress::findOrfail($id);

        return view('home.user.takeAddressInfo',compact('take','arealist'));
    }
    //修改收货地址
    public function editTakeAddress(Request $request){
        $data = $request->except(['_token','take_id']);
        $info = \Session::get('user');
        $rules = [
            'take_name'       => 'required',
            'take_phone'      => 'required',
            'take_area_1'     => 'required',
            'take_area_2'     => 'required',
            'take_area_3'     => 'required',
            'take_area_desc'  => 'required',
            'take_area_code'  => 'required|regex:/^[1-9][0-9]{5}$/',
        ];
        $errorMessage = [
            'take_name.required'      => '收货人姓名不能为空！',
            'take_phone.required'     => '联系电话不能为空！',
            'take_area_1.required'    => '省/直辖市不能为空！',
            'take_area_2.required'    => '市不能为空！',
            'take_area_3.required'    => '区/县不能为空！',
            'take_area_desc.required' => '详细地址不能为空！',
            'take_area_code.required' => '邮政编码不能为空！',
            'take_area_code.regex'    => '邮政编码格式不正确！',
        ];
        $this->validate($request,$rules,$errorMessage);

        //修改默认地址
        if($data['take_isdefault'] == 1)
        {
            Takeaddress::where('user_id',$info['user_id'])->update(['take_isdefault'=>0]);
        }
        //更新地址
        $res = Takeaddress::where('take_id',$request->get('take_id'))->update($data);
        if(!$res)
        {
            return Redirect::back()->withErrors('系统出现错误，请稍后尝试！');
        }
        return redirect(url('home/takeaddress'));

        
    }

    public function pwd(){

        return view('home.user.pwd');
    }
    public function modifyPwd(Request $request){
        $info = \Session::get('user');
        $pwd = User::where('user_id',$info['user_id'])->value('user_pwd');
        $newpwd = md5($request->get('userPwd'));
        $Ypwd = md5($request->get('userYpwd'));
        if($Ypwd != $pwd){
            return Redirect::back()->withErrors('当前密码输入有误！');
        }elseif($newpwd == $pwd){
            return Redirect::back()->withErrors('新密码与原密码一致！');
        }else{
            $rules = [
            'userPwd'       => 'required|confirmed|min:6|max:18',
            ];
            $errorMessage = [
                'userPwd.required'      => '新密码不能为空！',
                'userPwd.min'           => '新密码长度为6~18位！',
                'userPwd.max'           => '新密码长度为6~18位！',
                'userPwd.confirmed'     => '两次密码不一致！',
            ];
        }
        $this->validate($request,$rules,$errorMessage);
        $res = User::where('user_id',$info['user_id'])->update(['user_pwd' => $newpwd]);
        if($res){
            return Redirect::back()->withErrors('修改成功');
        }else{
            return Redirect::back()->withErrors('系统出现错误，请稍后尝试');
        }
    }
    //荣耀资质
    public function honor(){
        $honor = DB::table('user_honor')->get();
        return view('home.user.honor',compact('honor'));
        
    }
    public function delHonor($id){
        $data = array('status'=>-200,'msg'=>'系统出现错误，请稍后尝试');
        $res = DB::table('user_honor')->where('honor_id',$id)->delete();
        if($res){
            $data = array('status'=>200,'msg'=>'删除成功');
        }
        return $data;
    }
     //荣耀资质  上传图片
    public function honorUpload(Request $request){
        $info = \Session::get('user');
        $types = array('jpg','gif','jpeg','png','bmp');//定义检查的图片类型

        $name = $request->get('name');//上传图片的按钮name属性
        $pathname = $request->get('pathname');//图片容器的名称

        if (!$request->hasFile($name)){
            return $data = array('status'=>-200,'msg'=>'上传文件为空！');
         }

        $extension = $request->file($name)->getClientOriginalExtension();//获取图片后缀
        if(in_array($extension,$types) == false){
                return $data = array('status'=>-200,'msg'=>'上传图片格式错误！');
        }

        if(!$request->file($name)->isValid()){
            return $data = array('status'=>-200,'msg'=>'文件上传出错！');
        }
        $originalname = $request->file($name)->getClientOriginalName();//图片的原文件名
        $fileName = date('YmdHis',time()).uniqid().'.'.$extension;//定义文件名
        $request->file($name)->move('images/'.$pathname.'/', $fileName);//保存图片

        $honor['honor_file_name'] = '/images/'.$pathname.'/'. $fileName;
        $honor['user_id'] = $info['user_id'];
        $honor['honor_file_yname'] = $originalname;
        $honor['honor_type'] =1;
        $honor['created_at'] =date('Y-m-d H:i:s',time());
        $res = DB::table('user_honor')->insertGetId($honor);
        if($res > 0){
            return $data = array('status'=>200,'msg'=>'文件上传成功！','data'=>$honor['honor_file_name'],'honor_id'=>$res);
        }else{
            return $data = array('status'=>-200,'msg'=>'文件上传出错！');
        }

    }
    
    //账号设置---基本信息页面
    public function person(){
        $info = \Session::get('user');
        
        $user = User::findOrfail($info['user_id']);
        return view('home.user.person',compact('user'));
    }
    //账号设置---修改基本信息
    public function saveInfo(Request $request){
        $return_json = array('status'=>-400,'message'=>"系统出现错误，请稍后尝试放！");
        $user = User::findOrFail($request->get('user_id'));
        $data = $request->except(['_token', 'files','user_img']);
        //Base64 保存图片
        $fileroot = 'uploads/images/'.date("Ymd").'/';
        $data['user_img'] = $request->get('user_img') ? $this->basePic($request->get('user_img'),$fileroot):'';

        $res = $user->update($data);
        if($res)
            $return_json = array('status'=>400,'message'=>"修改成功");
        return $return_json;        
    }

     //需求管理--发布需求页面
    public function demand()
    {
        $category = SortDemand::where('sortdemand_parent_id', 0)->get();
        $area = AreaProvice::get();
        return view('home.user.demand', ['category'=>$category,'area'=>$area]);
    }
    //需求管理--获取需求下级分类
    public function demandCateChil(Request $request){
        $category = SortDemand::where('sortdemand_parent_id', $request->get('sortdemand_parent_id'))->get();
        echo json_encode($category);
    }
    //获取下级地区
    public function areaChil(Request $request){
        $area = DB::table($request->get('table'))->where($request->get('below'), $request->get('id'))->get();
        echo json_encode($area);
    }

    //账号设置---绑定手机
    public function savePhone(){
        return view('home.user.savephone');
    }
    public function doSavePhone(Request $request){
        $quest = $request->except(['_token']);
        $info = \Session::get('user');
        $time = date('Y-m-d H:i:s',time()-30*60);
        $code = DB::table('code')->where('user_id',$info['user_id'])->where('user_phone',$quest['user_phone'])->where('code_status',3)->orderBy('code_id','desc')->first();
        if(!$code){
            return Redirect::back()->withErrors('输入有误，请重新输入');
        }elseif($code->code_createtime <= $time){
            return Redirect::back()->withErrors('验证码已过期，请重新发送');
        }elseif($code->code_value != $quest['code']){
            return Redirect::back()->withErrors('验证码错误，请重新输入');
        }else{
            $data['user_phone'] = $quest['user_phone'];
            $re = User::where('user_id',$info['user_id'])->update($data);
            if(!$re){
                return Redirect::back()->withErrors('修改失败');
            }else{
                return redirect(url('home/person'));
            }
        }
    }
    //账号设置---绑定邮箱
    public function saveEmail(){

        return view('home.user.saveemail');
    }
    public function doSaveEmail(Request $request){
        $quest = $request->except(['_token']);
        $info = \Session::get('user');
        $time = date('Y-m-d H:i:s',time()-30*60);
        $code = DB::table('code')->where('user_id',$info['user_id'])->where('user_email',$quest['user_email'])->where('code_status',4)->orderBy('code_id','desc')->first();
        if(!$code){
            return Redirect::back()->withErrors('输入有误，请重新输入');
        }elseif($code->code_createtime <= $time){
            return Redirect::back()->withErrors('验证码已过期，请重新发送');
        }elseif($code->code_value != $quest['code']){
            return Redirect::back()->withErrors('验证码错误，请重新输入');
        }else{
            $data['user_email'] = $quest['user_email'];
            $re = User::where('user_id',$info['user_id'])->update($data);
            if(!$re){
                return Redirect::back()->withErrors('修改失败');
            }else{
                return redirect(url('home/person'));
            }
        }
    }


    public function doCode(Request $request){
        $data = array('status'=>-400,'msg'=>'');
        if($request->get('user_email')){
            $res = User::where('user_email',$request->get('user_email'))->first();
            if($res){
                $data['msg'] = '该邮箱已被注册';
                return $data;
            }else{
                return $this->doEmailCodes($request->get('user_email'));
             }
        }else if($request->get('user_phone')){
            $res = User::where('user_phone',$request->get('user_phone'))->first();
            if($res){
                $data['msg'] = '该手机号已被注册';
                return $data;
            }else{
                return $this->doPhoneCodes($request->get('user_phone'));
            }
        }
      
    }

    //发送手机验证码
    public function doPhoneCodes($phone){
        $info = \Session::get('user');
        $code = array('user_id'=>$info['user_id'],'code_value'=>rand(100000,999999),'user_phone'=>$phone,'code_status'=>3,'code_createtime'=>date('Y-m-d H:i:s',time()),'code_text'=>'手机绑定');
        $codes=$code['code_value'];
        date_default_timezone_set('Asia/Shanghai'); 
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $sms_type = 'SMS_34975022';
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("鼎迦信息");
        $req->setSmsParam ( "{code:\"$codes\"}" );
        $req->setRecNum($phone);
        $req->setSmsTemplateCode($sms_type);
        $resp = $c->execute($req);
        $isset_code=isset($resp->code);
        if($isset_code==false){
            DB::table('code')->insert($code);
            return $res = array('status'=>200,'msg'=>'手机验证码发送成功','data'=>$resp);
        }else{
            return $res = array('status'=>-400,'msg'=>'验证码发送失败，请重新尝试');
        }  
    }
    //发送邮箱验证码
    public function doEmailCodes($email){
        $info = \Session::get('user');
        $code = array('user_id'=>$info['user_id'],'code_value'=>rand(100000,999999),'user_email'=>$email,'code_status'=>4,'code_createtime'=>date('Y-m-d H:i:s',time()),'code_text'=>'邮箱绑定');
        date_default_timezone_set('Asia/Shanghai'); 
        $data = ['email'=>$email, 'code'=>$code['code_value']];
        $flag = \Mail::raw('您的验证码为：'.$data['code'].',该验证码有效期为30分钟！',function($message) use($data){
            $message->to($data['email'])->subject('诚信宝');
        });
        if($flag){
            DB::table('code')->insert($code);
            return $res = array('status'=>200,'msg'=>'邮箱验证码发送成功');
        }else{
            return $res = array('status'=>-400,'msg'=>'邮箱验证发送失败，请重新尝试');
        }
    }


   
 
































































    public function create()
    {   $categories = Category::all();
        return view('admin.user.create',compact('categories'));
    }

 
    public function store(Request $request)
    {   
       
    }


    public function edit($id)
    {
        $user = User::find($id);
        $categories = Category::all();
        $position = Position::all();
        return view('admin.user.edit', compact('user','categories','position'));
    }


    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $data = $request->except(['_token']);
        
            if ($request->hasFile('user_portrait')) {
             
                $destinationPath = 'images/user/user_portrait/';
                $fileName = time() . $request->file('user_portrait')->getClientOriginalName();

                if ($request->file('user_portrait')->move($destinationPath, $fileName))
                    $data['user_portrait'] = '/' . $destinationPath . $fileName;
            } else {
                $data['user_portrait'] = $request->get('user_portrait');
            }
             $user->update($data);
             return redirect(url('admin/user'));
        } else {
            abort(404);
        }
    }

      public function upload(Request $request)
    {
        $ret = ['code' => 0, 'msg' => '', 'src' => ''];
        if ($request->hasFile('image')) {
            $destinationPath = 'images/user/';
            $fileName = time() . $request->file('image')->getClientOriginalName();
            if ($request->file('image')->move($destinationPath, $fileName)) {
                $ret['code'] = 1;
                $ret['src'] = '/' . $destinationPath . $fileName;
            } else {
                $ret['msg'] = '网络错误,上传失败';
            }
        } else {
            $ret['msg'] = '请选择图片';
        }

        return $ret;
    }

  
    public function destroy($id)
    {
        //
        if (User::destroy($id))
            return 1;
        else
            return 0;
    }

}

