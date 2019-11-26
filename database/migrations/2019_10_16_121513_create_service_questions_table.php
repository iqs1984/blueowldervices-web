<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('service_offer_id')->unsigned();
            $table->longText('question');
            $table->integer('question_id')->nullable();
            $table->longText('price');
            $table->foreign('service_offer_id')->references('id')->on('service_offers')->onDelete('cascade');
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
        Schema::dropIfExists('service_questions');
    }
}
