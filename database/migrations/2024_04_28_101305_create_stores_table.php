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
            $table->string('store_code')->nullable();
            $table->string('store_name');
            $table->foreignId('user_id')->constrained('users');
            $table->string('store_phone');
            $table->string('store_logo')->nullable();
            $table->string('store_address');
            $table->string('store_instagram');
            $table->string('store_tokopedia');
            $table->string('store_shopee');
            $table->bigInteger('store_province')->unsigned();
            $table->bigInteger('store_city')->unsigned();
            $table->bigInteger('store_district')->unsigned();
            $table->bigInteger('store_subdistrict')->unsigned();
            $table->bigInteger('store_postal_code')->unsigned()->nullable();
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
