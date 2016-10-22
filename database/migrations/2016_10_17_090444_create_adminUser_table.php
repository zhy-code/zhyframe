<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user', function (Blueprint $table) {
            $table->increments('user_id')->comment('后台管理员自增Id');
            $table->string('user_name', 30)->unique()->comment('后台管理员名/账号');
            $table->string('user_password', 50)->comment('后台管理员密码');
			$table->tinyInteger('user_status')->default(0)->comment('后台管理员状态 0正常，1禁用');
            $table->string('user_remark',100)->comment('后台管理员备注');
			$table->Integer('user_last_login_time')->comment('最后登录时间');
			$table->string('user_last_login_ip',20)->comment('最后登录IP');
			$table->string('user_true_name', 30)->comment('后台管理员姓名');
			$table->Integer('user_add_time')->comment('后台管理员添加时间');
			$table->string('user_add_ip',20)->comment('后台管理员添加IP');
			$table->Integer('user_edit_time')->comment('后台管理员最后编辑的时间');
			$table->string('user_eidt_ip', 20)->comment('后台管理员最后编辑的IP');
            $table->string('user_login_rnd', 64)->comment('后台管理员登陆标识符，随机数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user');
    }
}
