<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('currency_code_id_1');
            $table->unsignedBigInteger('currency_code_id_2');
            $table->boolean('status')->default(1);            
            $table->timestamps();

            $table->unique(['user_id','currency_code_id_1', 'currency_code_id_2']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('currency_code_id_1')->references('id')->on('currency_codes')->onDelete('cascade');
            $table->foreign('currency_code_id_2')->references('id')->on('currency_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favourites');
    }
}
