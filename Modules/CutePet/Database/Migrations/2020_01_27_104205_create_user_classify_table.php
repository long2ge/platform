<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserClassifyTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'user_classify';
        $dbConnection = config('modules.post.config.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table){
            $table->integer('user_id')->comment('帖子ID');
            $table->integer('classify_id')->comment('板块ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = 'user_classify';
        $dbConnection = config('modules.post.config.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
