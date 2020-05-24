<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostEnshrinesTable extends Migration
{
    /**用户收藏帖子表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'post_enshrines';
        $dbConnection = config('modules.post.config.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table) {
            $table->integer('user_id')->comment('用户ID');
            $table->integer('post_id')->comment('帖子ID');
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
        $table = 'post_enshrines';
        $dbConnection = config('modules.post.config.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
