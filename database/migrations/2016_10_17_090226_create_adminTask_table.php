<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_task', function (Blueprint $table) {
			$table->increments('task_id')->comment('任务自增Id');
            $table->string('task_title', 255)->comment('任务标题');
            $table->text('task_content')->comment('任务内容');
			$table->Integer('task_creator')->comment('任务发布人Id');
			$table->Integer('task_finisher')->comment('任务完成人Id');
			$table->string('task_datetime', 50)->comment('任务预定开展时间');
			$table->tinyInteger('task_weekday')->comment('任务预定开展的星期数');
			$table->Integer('task_add_time')->comment('任务添加的时间');
			$table->string('task_add_ip', 20)->comment('任务添加的IP');
			$table->Integer('task_edit_time')->comment('任务最后编辑的时间');
			$table->string('task_eidt_ip', 20)->comment('任务最后编辑的IP');
			$table->tinyInteger('task_status')->default(0)->comment('任务状态 0未做，1已完成，-1已过期');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_task');
    }
}
