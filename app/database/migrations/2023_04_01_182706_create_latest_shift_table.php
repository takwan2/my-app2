<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('latest_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('day_id')->references('id')->on('days');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('day_id');
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
        Schema::dropIfExists('latest_shift');
    }
};
