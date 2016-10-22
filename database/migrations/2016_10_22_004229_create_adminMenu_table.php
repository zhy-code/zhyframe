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
            $table->increments('menu_id')->comment('后台菜单自增Id');
            $table->Integer('menu_parent_id')->default(0)->comment('后台菜单父类Id');
            $table->string('menu_name', 30)->unique()->comment('后台菜单名称');
			$table->tinyInteger('menu_status')->default(0)->comment('后台菜单状态 0不显示，1显示');
            $table->string('menu_module', 50)->default('')->comment('后台菜单模块');
            $table->string('menu_controller', 50)->default('')->comment('后台菜单控制器');
            $table->string('menu_action', 50)->default('')->comment('后台菜单方法');
            $table->string('menu_parameter', 100)->default('')->comment('后台菜单方法');
			$table->string('menu_icon', 50)->default('')->comment('后台菜单标识符');
            $table->string('menu_remark',100)->default('')->comment('后台菜单备注');
			$table->smallInteger('menu_sort')->comment('后台菜单排序');
			$table->Integer('menu_add_time')->comment('后台菜单添加时间');
			$table->string('menu_add_ip',20)->comment('后台菜单添加IP');
			$table->integer('menu_creator')->unsigned()->comment('后台菜单添加者id');
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
