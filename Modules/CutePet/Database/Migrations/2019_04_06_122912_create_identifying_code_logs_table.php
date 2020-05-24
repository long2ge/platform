<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentifyingCodeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'identifying_code_logs';
        $dbConnection = config('modules.core.config.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone_number', 20)->comment('手机号码');
            $table->string('code', 10)->comment('验证码');
            $table->string('content')->comment('短信内容');
            $table->string('business_type', 20)->comment('短信类型, modify_password, register');
            $table->string('source', 30)->comment('来源, wechat_mini 小程序 wechat 微信公众号， web 网页，app app来源');
            $table->timestamp('created_at')->nullable();
        });

        DB::connection($dbConnection)->statement("ALTER TABLE `$table` comment '验证码记录表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = 'identifying_code_logs';
        $dbConnection = config('modules.core.config.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
