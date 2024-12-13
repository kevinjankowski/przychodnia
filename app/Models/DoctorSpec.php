<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSpec extends Model
{
    protected $table = 'doctor_spec'; // Ustawia nazwę tabeli jeśli ta jest inna niż nazwa klasy (tutaj DoctorSpec),
    protected $primaryKey = 'doctor_spec_id'; // Nazwa klucza głównego
    protected $fillable = ['doctor_id', 'specialization_id']; // Nazwy pól, które można wypełnić
}
