<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarColumnUserCar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_cars', function (Blueprint $table) {
            $table->bigInteger('car_brand_id')->nullable()->after('user_id');
            $table->string('car_year')->nullable()->after('car_model_id');
            $table->string('car_model_name')->nullable()->after('car_year');
            $table->string('car_brand_logo')->nullable()->after('car_model_name');
            $table->string('car_engine_name')->nullable()->after('car_brand_logo');
        });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_cars', function (Blueprint $table) {
            //
        });
    }
}
