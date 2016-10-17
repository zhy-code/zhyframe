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
			
            $table->text('task_content')->comment('任务内容');
			$table->Integer('task_publisher')->comment('任务发布人Id');
			$table->Integer('task_finisher')->comment('任务完成人Id');
			$table->string('task_datetime', 50)->comment('任务预定开展时间');
			$table->tinyInteger('task_weekday')->comment('任务预定开展的星期数');
			$table->Integer('task_add_time')->comment('任务添加的时间');
			$table->string('task_add_ip', 20)->comment('任务添加的IP');
			$table->Integer('task_edit_time')->comment('任务最后编辑的时间');
			$table->string('task_eidt_ip', 20)->comment('任务最后编辑的IP');
			$table->tinyInteger('task_status')->comment('任务状态 0未做，1已完成，-1已过期');
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
