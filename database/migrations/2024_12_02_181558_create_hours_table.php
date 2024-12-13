<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursTable extends Migration
{
    public function up()
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->id('hour_id'); // Primary key
            $table->time('hour'); // Hour column

        });
    }

    public function down()
    {
        Schema::dropIfExists('hours');
    }
}
