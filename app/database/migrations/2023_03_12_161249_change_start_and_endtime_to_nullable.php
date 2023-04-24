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
        Schema::table('day_user', function (Blueprint $table) {
            $table->string('start_time')->nullable(true)->change();
            $table->string('end_time')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_user', function (Blueprint $table) {
            $table->string('start_time')->nullable(false)->change();
            $table->string('end_time')->nullable(false)->change();
        });
    }
};
