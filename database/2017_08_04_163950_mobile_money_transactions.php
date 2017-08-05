<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MobileMoneyTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('mobile_money_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('model')->nullable();
            $table->unsignedInteger('transaction_id');
            $table->string('phone');
            $table->unsignedInteger('price');  
            $table->unsignedInteger('model_id')->nullable();
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
            Schema::dropIfExists('mobile_money_transactions');
    }
}
