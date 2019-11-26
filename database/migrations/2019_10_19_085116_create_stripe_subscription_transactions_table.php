<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripeSubscriptionTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_subscription_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_id')->unsigned();
            $table->string('transaction_id');
            $table->string('subscription_type');
            $table->string('amount')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->foreign('sub_id')->references('id')->on('stripe_subscriptions')->onDelete('cascade');
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
        Schema::dropIfExists('stripe_subscription_transactions');
    }
}
