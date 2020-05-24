<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurisdictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = 'jurisdictions';
        $dbConnection = config('cutepet.db-connection');
        Schema::connection($dbConnection)
            ->create($tableNames, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('名字');
            $table->tinyInteger('class')->comment('等级');
            $table->tinyInteger('up_class_id')->comment('上级id');
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
        Schema::dropIfExists('jurisdictions');
    }
}
