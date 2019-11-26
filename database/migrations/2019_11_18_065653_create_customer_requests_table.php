<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('question_id')->unsigned();
			$table->bigInteger('location_id')->unsigned();
			$table->bigInteger('service_id')->unsigned();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('price');
			$table->integer('status');
			$table->foreign('question_id')->references('id')->on('service_questions')->onDelete('cascade');
			$table->foreign('location_id')->references('id')->on('area_serveds')->onDelete('cascade');
			$table->foreign('service_id')->references('id')->on('service_categories')->onDelete('cascade');
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
        Schema::dropIfExists('customer_requests');
    }
}
