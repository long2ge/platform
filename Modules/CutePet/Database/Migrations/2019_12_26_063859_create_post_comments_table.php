<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCommentsTable extends Migration
{
    /**帖子楼层表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'post_comments';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户ID');
            $table->integer('post_id')->comment('帖子ID');
            $table->integer('post_user_id')->comment('帖子用户ID');
            $table->integer('tower')->comment('楼层');
            $table->string('content')->comment('内容');
            $table->tinyInteger('shield')->default(0)->comment('屏蔽');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = 'post_comments';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
