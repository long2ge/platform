<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Core\Database\Seeders\RegionTableSeederTableSeeder;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = 'regions';
        $dbConnection = config('modules.core.config.db-connection');
        Schema::connection($dbConnection)->create($table, function (Blueprint $table) {
            $table->unsignedInteger('id')->comment('行政编码');
            $table->primary('id');
            $table->string('name')->comment('省市区名');
            $table->unsignedInteger('pid')->default(0)->comment('父级编码');
            $table->char('capital', 1)->comment('拼音首字母');
            $table->string('pinyin')->comment('拼音全拼');
            $table->unsignedTinyInteger('level')->default(1)->comment('等级');
            $table->boolean('enable')->default(1)->comment('是否启用 1启用， 0不启用');
        });

        DB::connection($dbConnection)->statement("ALTER TABLE `$table` comment '地区表'");

        app(RegionTableSeederTableSeeder::class)->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = 'regions';
        $dbConnection = config('modules.core.config.db-connection');
        Schema::connection($dbConnection)->dropIfExists($table);
    }
}
