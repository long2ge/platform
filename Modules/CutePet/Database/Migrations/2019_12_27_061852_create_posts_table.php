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
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户ID');
            $table->string('title')->comment('标题');
            $table->string('content')->comment('内容');
            $table->integer('view')->default(0)->comment('浏览量');
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
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
