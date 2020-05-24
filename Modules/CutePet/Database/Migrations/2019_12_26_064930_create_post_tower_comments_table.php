<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTowerCommentsTable extends Migration
{
    /**帖子楼内评论表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'post_tower_comment';
        $dbConnection = config('modules.post.config.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('up_user_id')->comment('上级用户ID');
            $table->integer('post_id')->comment('所属帖子ID');
            $table->integer('post_comment_id')->comment('所属帖子评论ID');
            $table->integer('up_user_comment_id')->comment('上级用户评论ID');
            $table->integer('user_id')->comment('用户ID');
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
        $table = 'post_tower_comment';
        $dbConnection = config('modules.post.config.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
