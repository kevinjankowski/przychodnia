<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id('doctor_id'); // Primary key
            $table->string('first_name', 32);
            $table->string('last_name', 64);

        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
