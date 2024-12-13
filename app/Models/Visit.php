<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $primaryKey = 'visit_id'; // Nazwa klucza głównego
    public $timestamps = false; // Wyłączenie pól created_at i updated_at
    protected $fillable = ['date', 'hour_id', 'patient_id', 'doctor_id']; // Nazwy pól, które można wypełnić

    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function hour(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hour::class, 'hour_id');
    }


}
