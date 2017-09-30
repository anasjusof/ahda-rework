<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('car_id')->nullable();
            $table->integer('attachment_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('approval')->default(0)->comment = "0. Pending, 1. Approved 2. Reject";
            $table->string('destination');
            $table->integer('total_passenger')->default(1);
            $table->string('purpose');
            $table->string('remarks');
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
        Schema::drop('booking_histories');
    }
}
