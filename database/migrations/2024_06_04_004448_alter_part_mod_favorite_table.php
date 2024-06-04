<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPartModFavoriteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->bigInteger('part_id')->unsigned()->nullable()->change();
            $table->bigInteger('mod_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->bigInteger('part_id')->unsigned()->nullable(false)->change();
            $table->bigInteger('mod_id')->unsigned()->nullable(false)->change();
        });
    }
}
