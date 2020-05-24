<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostPraisesTable extends Migration
{
    /**点赞帖子表
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'post_praises';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table){
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
        $table = 'post_praises';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
