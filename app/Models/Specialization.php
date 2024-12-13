<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $primaryKey = 'specialization_id'; // Nazwa klucza głównego
    protected $fillable = ['name']; // Nazwy pól, które można wypełnić

    // Relacja do tabeli łączącej lekarzy z ich specjalizacjami (wiele-do-wielu)
    public function doctors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        // Opis poszczególnych argumentów poniższej funcji znajduje się w modelu Doctor
        return $this->belongsToMany(Doctor::class, 'doctor_spec', 'specialization_id', 'doctor_id');
    }
}
