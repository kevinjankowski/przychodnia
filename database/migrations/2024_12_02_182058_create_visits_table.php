<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id('visit_id'); // Primary key
            $table->date('date'); // Visit date
            $table->unsignedBigInteger('hour_id'); // Foreign key to hours
            $table->string('patient_id', 11); // Foreign key to patients
            $table->unsignedBigInteger('doctor_id'); // Foreign key to doctors


            // Foreign key constraints
            $table->foreign('hour_id')->references('hour_id')->on('hours')->onDelete('cascade');
            $table->foreign('patient_id')->references('pesel')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('doctor_id')->on('doctors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
