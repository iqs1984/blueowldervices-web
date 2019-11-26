<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOffers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_offers', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('offered_id')->unsigned();
            $table->unique(["user_id","offered_id"]);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('offered_id')->references('id')->on('service_offers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_offers');
    }
}
