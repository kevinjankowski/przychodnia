<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $primaryKey = 'pesel'; // Nazwa klucza głównego
    public $incrementing = false;   // Jeśli PESEL nie jest liczbowym ID
    protected $keyType = 'string';  // Jeśli PESEL to string
    public $timestamps = false;

    protected $fillable = ['pesel', 'first_name', 'last_name']; // Nazwy pól, które można wypełnić

    // Relacja do tabeli z wizytami
    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(
            Visit::class, // Nazwa modelu, z którym relacja jest zdefiniowana
            'patient_id', // Nazwa pola, z którym łączy się klucz obcy w tabeli Visit
            'pesel'); // Lokalna nazwa pola, od którego wychodzi klucz obcy
    }
}
