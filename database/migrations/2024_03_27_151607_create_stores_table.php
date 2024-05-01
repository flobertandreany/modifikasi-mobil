<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('store_code');
            $table->foreignId('user_id')->constrained('users');
            $table->string('store_address');
            $table->string('store_phone');
            $table->string('store_instagram');
            $table->string('store_tokopedia');
            $table->string('store_shopee');
            $table->string('store_city');
            $table->string('store_district');
            $table->string('store_village');
            $table->string('store_postal_code');
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
        Schema::dropIfExists('stores');
    }
}
