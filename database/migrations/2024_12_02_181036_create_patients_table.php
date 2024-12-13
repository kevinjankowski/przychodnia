<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->string('pesel', 11)->primary(); // Primary key
            $table->string('first_name', 32);
            $table->string('last_name', 32);

        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
