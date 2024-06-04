<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSparepartPriceSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spareparts', function (Blueprint $table) {
            $table->decimal('sparepart_price', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spareparts', function (Blueprint $table) {
            $table->string('sparepart_price')->change();
        });
    }
}
