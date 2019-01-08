<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userrequests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_user_id')->unsigned()->nullable();
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('to_user_id')->unsigned()->nullable();
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('userrequests');
    }
}
