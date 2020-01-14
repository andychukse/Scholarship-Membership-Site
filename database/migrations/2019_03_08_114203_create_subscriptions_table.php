<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('plan_id');
            $table->integer('user_id')->unsigned();
            $table->string('reference');
            $table->string('auth_code')->nullable();
            $table->tinyInteger('provider')->nullable(); //1-paystack, 2-bank
            $table->tinyInteger('status')->default(0); //1-paid, 0-pending
            $table->tinyInteger('state')->default(0); //1-active, 0-canceled
            $table->timestamp('end_at')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
}
