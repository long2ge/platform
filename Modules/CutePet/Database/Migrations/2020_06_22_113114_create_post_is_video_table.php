<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostIsVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'post_is_video';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('post_id')->comment('视频帖子ID');
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
        Schema::dropIfExists('post_is_video');
    }
}
