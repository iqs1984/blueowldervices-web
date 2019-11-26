<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('companyname');
            $table->string('email')->unique();
			$table->integer('phone')->nullable();
			$table->string('licence_number')->nullable();
			$table->text('website_url')->nullable();
			$table->text('yelp_url')->nullable();
			$table->text('service_category')->nullable();
			$table->text('about_service')->nullable();
			$table->string('role');
			$table->text('imgpath')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
