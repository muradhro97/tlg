<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtractImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extract_images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('image_thumb');

            $table->bigInteger('extract_id')->unsigned();

            //keys
            $table->foreign('extract_id')->references('id')->on('extracts')->onDelete('cascade');

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
        Schema::dropIfExists('extract_images');
    }
}
