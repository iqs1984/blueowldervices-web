<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripeSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('subscription_id');
            $table->string('customer_id');
            $table->string('cancel')->nullable();
            $table->timestamp('subscription_at')->nullable();
            $table->timestamp('cancel_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('stripe_subscriptions');
    }
}
