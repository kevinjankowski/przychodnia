<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSpecTable extends Migration
{
    public function up()
    {
        Schema::create('doctor_spec', function (Blueprint $table) {
            $table->id('doctor_spec_id'); // Primary key
            $table->unsignedBigInteger('doctor_id'); // Foreign key to doctors
            $table->unsignedBigInteger('specialization_id'); // Foreign key to specializations


            // Foreign key constraints
            $table->foreign('doctor_id')->references('doctor_id')->on('doctors')->onDelete('cascade');
            $table->foreign('specialization_id')->references('specialization_id')->on('specializations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_spec');
    }
}
