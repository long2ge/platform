<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostClassifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'post_classify';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table){
            $table->integer('post_id')->comment('帖子ID');
            $table->integer('classify_id')->comment('板块ID');
            $table->integer('is_top')->comment('是否设顶');
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
        $table = 'post_classify';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
