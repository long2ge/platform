<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'users';
        $dbConnection = config('modules.user.config.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('account')->nullable()->comment('账号');
            $table->string('user_name')->nullable()->comment('用户名');
            $table->string('phone_number', 20)->nullable()->comment('手机号码');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('password')->nullable()->comment('密码');
            $table->unsignedInteger('occupation_id')->nullable()->comment('职业id');
            $table->string('profile')->default('')->comment('个人简介');
            $table->string('avatar')->default('')->comment('头像url');
            $table->string('address')->default('')->comment('详细地址');
            $table->unsignedInteger('province_id')->default(0)->comment('省份id');
            $table->unsignedInteger('city_id')->default(0)->comment('城市id');
            $table->unsignedInteger('zone_id')->default(0)->comment('区/县 id');
            $table->boolean('sex')->default(1)->comment('性别 1男，0女');
            $table->boolean('status')->default(1)->comment('用户状态 1正常，0冻结');
            $table->integer('class')->default(0)->comment('等级');
            $table->integer('authority_class')->default(0)->comment('权益_等级');
            $table->integer('post_sum')->default(0)->comment('评论总数');
            $table->integer('comment_sum')->default(0)->comment('发帖总数');
            $table->integer('maintain_post_sum')->default(0)->comment('保级发帖');
            $table->integer('maintain_comment_sum')->default(0)->comment('保级评论');
            $table->tinyInteger('maintain_authority_class')->default(0)->comment('是否保级');
            $table->dateTime('authority_finish')->nullable()->comment('权益结束时间');
            $table->timestampsTz();
            $table->softDeletes();
        });

        DB::connection($dbConnection)->statement("ALTER TABLE `$table` comment '用户表'");

        DB::connection($dbConnection)->statement("ALTER TABLE `$table` AUTO_INCREMENT = 10000001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = 'users';
        $dbConnection = config('modules.user.config.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
