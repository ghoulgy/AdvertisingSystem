<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkersdemandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markersdemand', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->tinyInteger('type')->comment('1:Food,2:Delivery;3:Computer;4:Others');
            $table->tinyInteger('need')->comment('1:Normal,2:Urgent');
            $table->string('title', 50);
            $table->string('description', 150);
            $table->float('lng', 10, 6);
            $table->float('lat', 10, 6);
            $table->integer('user_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('markersdemand');
    }
}
