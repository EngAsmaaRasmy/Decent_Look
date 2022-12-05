<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderChangeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_change_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('from_status_id')->nullable();
            $table->integer('to_status_id')->nullable();
            //$table->unsignedBigInteger('from_status_id')->index();
            //$table->foreign('from_status_id')->references('id')->on('status') ->onDelete('cascade');
            //$table->unsignedBigInteger('to_status_id')->index();
            //$table->foreign('to_status_id')->references('id')->on('status') ->onDelete('cascade');


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
        Schema::dropIfExists('order_change_histories');
    }
}
