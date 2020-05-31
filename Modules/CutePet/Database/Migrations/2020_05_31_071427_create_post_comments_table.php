<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = 'post_comments';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)
            ->create($tableNames, function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('post_id')->comment('所属帖子ID');
            $table->integer('comment_user_id')->comment('评论用户ID');
            $table->string('comment_content')->comment('评论内容');
            $table->tinyInteger('type')->default(0)->comment('类型 0回复主帖，1回复评论');
            $table->integer('reply_comment_id')->default(0)->comment('回复的评论ID');
            $table->integer('reply_comment_user_id')->default(0)->comment('回复的评论用户ID');
            $table->integer('praise')->default(0)->comment('点赞数');
            $table->tinyInteger('astrict')->default(0)->comment('0不限制，1屏蔽，2已删除');
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
        Schema::dropIfExists('post_comments');
    }
}
