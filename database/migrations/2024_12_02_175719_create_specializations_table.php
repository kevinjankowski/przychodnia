<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecializationsTable extends Migration
{
    public function up()
    {
        Schema::create('specializations', function (Blueprint $table) {
            $table->id('specialization_id'); // Primary key
            $table->string('name', 64);

        });
    }

    public function down()
    {
        Schema::dropIfExists('specializations');
    }
}
