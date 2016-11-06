@extends('admin.common.zhyframe')

@section('head')
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
			</div>
			<div class="ibox-content">
				<form method="get" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label">提示</label>
						<div class="col-sm-8">
							<input type="text" placeholder="提示信息" class="form-control"><!-- input-sm/input-lg -->
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label ftz-20">密码</label>

						<div class="col-sm-8">
							<input type="password" class="form-control" placeholder="请输入密码"  name="password">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label ftz-20">密码</label>

						<div class="col-sm-8">
							<input type="date" class="form-control" name="password">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label ftz-20">密码</label>

						<div class="col-sm-8">
							<input type="color" class="form-control" name="password">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label ftz-16">
							选择框XX
						</label>

						<div class="col-sm-8">
							<div class="checkbox"><!--checkbox-inline-->
								<label>
									<input type="checkbox" class="input-checkbox"><i class="mr-5">✓</i>选项1
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" class="input-checkbox" checked><i class="mr-5">✓</i>选项2（选中）
								</label>
							</div>
							
							<div class="radio">
								<label>
									<input type="radio" class="input-radio" value="option1" name="a"><i class="mr-5">✓</i>选项1</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Select</label>
						<div class="col-sm-8"><!-- has-success/has-warning/has-error -->
							<select class="form-control m-b" name="account">
								<option>选项 1</option>
								<option>选项 2</option>
								<option>选项 3</option>
								<option>选项 4</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">列尺寸</label>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-md-2">
									<input type="text" placeholder=".col-md-2" class="form-control">
								</div>
								<div class="col-md-3">
									<input type="text" placeholder=".col-md-3" class="form-control">
								</div>
								<div class="col-md-4">
									<input type="text" placeholder=".col-md-4" class="form-control">
								</div>
							</div>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-2 control-label">文本框组</label>

						<div class="col-sm-8">
							<div class="input-group m-b"><span class="input-group-addon">&yen;</span>
								<input type="text" class="form-control"> <span class="input-group-addon">.00</span>
							</div>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-2 control-label">按钮插件</label>

						<div class="col-sm-8">
							<div class="input-group">
								<input type="text" class="form-control"> <span class="input-group-btn"> <button type="button" class="btn btn-primary">搜索
								</button> </span>
							</div>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-2 control-label">带下拉框</label>

						<div class="col-sm-8">
							<div class="input-group">
								<input type="text" class="form-control">

								<div class="input-group-btn">
									<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">操作 <span class="caret"></span>
									</button>
									<ul class="dropdown-menu pull-right">
										<li><a href="form_basic.html#">选项1</a>
										</li>
										<li><a href="form_basic.html#">选项2</a>
										</li>
										<li><a href="form_basic.html#">选项3</a>
										</li>
										<li class="divider"></li>
										<li><a href="form_basic.html#">选项4</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-4 col-sm-offset-2">
							<button class="btn btn-primary" type="submit">保&nbsp;&nbsp;存</button>
							<button class="btn btn-white ml-15" type="submit">取&nbsp;&nbsp;消</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer')
<script src="{{asset('js/public.js')}}"></script>
@endsection