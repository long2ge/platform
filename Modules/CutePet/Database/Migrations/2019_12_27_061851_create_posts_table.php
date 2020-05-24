<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**帖子表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'posts';
        $dbConnection = config('modules.post.config.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户ID');
            $table->string('title')->comment('标题');
            $table->string('content')->comment('内容');
            $table->integer('view')->default(0)->comment('浏览量');
            $table->tinyInteger('hot')->default(0)->comment('热');
            $table->tinyInteger('perfect')->default(0)->comment('精华');
            $table->tinyInteger('top')->default(0)->comment('设顶');
            $table->tinyInteger('recommend')->default(0)->comment('推荐');
            $table->tinyInteger('shield')->default(0)->comment('屏蔽');
            $table->tinyInteger('is_vip')->default(0)->comment('Vip');
            $table->tinyInteger('is_video')->default(0)->comment('视频帖子');
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
        $table = 'posts';
        $dbConnection = config('modules.post.config.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
