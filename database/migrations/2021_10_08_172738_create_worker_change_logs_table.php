<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_change_logs', function (Blueprint $table) {
            $table->id();

            $table->string('change_type');
            $table->string('change_value');

            // foreign keys
            $table->bigInteger('worker_id')->unsigned();

            // relations
            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');

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
        Schema::dropIfExists('worker_change_logs');
    }
}
