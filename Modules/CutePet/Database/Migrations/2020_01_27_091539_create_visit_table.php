<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'visit';
        $dbConnection = config('modules.user.config.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table) {
            $table->integer('visit_user_id')->comment('访客ID');
            $table->integer('user_id')->comment('用户ID');
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
        $table = 'visit';
        $dbConnection = config('modules.user.config.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
