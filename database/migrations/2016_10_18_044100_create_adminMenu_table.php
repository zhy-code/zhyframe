<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menu', function (Blueprint $table) {
            $table->increments('menu_id')->comment('菜单自增Id');
            $table->string('menu_parent_id', 255)->comment('菜单父Id');
            $table->text('menu_name')->comment('菜单名称');
			$table->string('menu_app', 50)->comment('菜单所属应用 admin/home');
			$table->string('menu_model', 50)->comment('菜单所属模块/控制器');
			$table->string('menu_action', 50)->comment('菜单所用方法');
			$table->string('menu_parameter', 150)->comment('菜单所含参数');
			$table->string('menu_action', 50)->comment('菜单所用方法');
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
        Schema::dropIfExists('admin_menu');
    }
}
