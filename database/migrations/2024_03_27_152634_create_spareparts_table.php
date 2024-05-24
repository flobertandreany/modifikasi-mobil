<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('store_id')->constrained('stores');
            $table->string('sparepart_name');
            $table->string('sparepart_image');
            $table->string('sparepart_price');
            $table->string('sparepart_weight');
            $table->string('sparepart_height');
            $table->string('description', 1000);
            $table->string('link_tokopedia');
            $table->string('link_shopee');
            $table->string('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spareparts');
    }
}
