<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $primaryKey = 'doctor_id'; // Nazwa klucza głównego
    protected $fillable = ['first_name', 'last_name']; // Nazwy pól, które można wypełnić

    // Relacja do tabeli łączącej lekarzy z ich specjalizacjami (wiele-do-wielu)
    public function specializations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Specialization::class, // Nazwa modelu, z którym relacja jest zdefiniowana
            'doctor_spec', // Nazwa tabeli pośredniej (pivot)
            'doctor_id', // Klucz obcy w tabeli pivot odnoszący się do bieżącego modelu (tutaj Doctor)
            'specialization_id'); // Klucz obcy w tabeli pivot odnoszący się do modelu powiązanego (tutaj Specialization)
    }

    // Relacja do tabeli z wizytami (jeden-do-wielu)
    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
