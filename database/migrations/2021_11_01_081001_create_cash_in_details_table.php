<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashInDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_in_details', function (Blueprint $table) {
            $table->id();

            $table->integer('quantity')->nullable();
            $table->decimal('price');
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('accounting_id')->unsigned();
            $table->integer('exchange_ratio')->nullable();

            // relations
            $table->foreign('item_id')->references('id')->on('extract_items')->onDelete('cascade');
            $table->foreign('accounting_id')->references('id')->on('accounting')->onDelete('cascade');
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
        Schema::dropIfExists('cash_in_details');
    }
}
