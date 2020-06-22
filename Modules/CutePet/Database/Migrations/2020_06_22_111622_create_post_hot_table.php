<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostHotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'post_hot';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table){
            $table->bigIncrements('id');
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
        Schema::dropIfExists('post_hot');
    }
}
