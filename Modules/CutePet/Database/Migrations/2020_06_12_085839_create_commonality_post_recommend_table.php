<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonalityPostRecommendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = 'commonality_post_recommend';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)
            ->create($tableNames, function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('post_id');
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
        Schema::dropIfExists('commonality_post_recommend');
    }
}
