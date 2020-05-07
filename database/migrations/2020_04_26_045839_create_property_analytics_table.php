<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_analytics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties');
            $table->unsignedInteger('analytic_type_id');
            $table->foreign('analytic_type_id')->references('id')->on('analytic_types');
            $table->text('value');
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
        Schema::dropIfExists('property_analytics');
    }
}
