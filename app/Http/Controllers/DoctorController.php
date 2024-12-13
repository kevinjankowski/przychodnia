<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
class DoctorController extends Controller
{
    public function index(): JsonResponse
    {
        // Pobranie wszystkich doktorów z ich specjalizacjami
        $doctors = Doctor::with('specializations')->get();

        // Transformacja danych na żądany format JSON
        $response = $doctors->map(function ($doctor) {
            return [
                'doctor_id' => $doctor->doctor_id,
                'first_name' => $doctor->first_name,
                'last_name' => $doctor->last_name,
                'specializations' => $doctor->specializations->pluck('name')->toArray(),
            ];
        });

        return response()->json($response);
    }
}
