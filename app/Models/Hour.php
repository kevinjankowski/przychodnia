<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    protected $primaryKey = 'hour_id'; // Nazwa klucza głównego
    protected $fillable = ['hour']; // Nazwy pól, które można wypełnić

    // Relacja do tabeli z wizytami (jeden-do-wielu)
    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
