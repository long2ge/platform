<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $dbConnections = config('admin.db-connection');
        $tableNames = 'users';

        Schema::connection($dbConnections)
            ->create($tableNames, function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('username')->unique()->nullable()->comment('账号名');
                $table->string('name')->comment('用户昵称');
                $table->string('email')->unique()->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->comment('密码');
                $table->string('avatar')->nullable()->comment('头像');
                $table->string('real_name')->nullable()->comment('真名');
                $table->boolean('sex')->nullable()->comment('性别');
                $table->date('birthday')->nullable()->comment('生日');
                $table->string('phone', 20)->unique()->nullable()->comment('手机号码');
                $table->integer('role_id')->unsigned()->default(0)->comment('角色id');
                $table->tinyInteger('status')->default(1)->comment('状态 0 冻结, 1正常');
                $table->string('jurisdictions_ids')->comment('权限ID字符串');
                $table->softDeletes();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $dbConnections = config('database.connections.admin.connection');
        $tableNames = 'users';
        Schema::connection($dbConnections)->dropIfExists($tableNames);
    }
}
