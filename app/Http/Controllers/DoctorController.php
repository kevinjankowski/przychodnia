<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
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

    // Pobieranie lekarzy z daną specjalizacją podaną przez użytkownika
    public function getDoctorsBySpec(Request $request): JsonResponse
    {
        // Pobieramy specjalizację z zapytania
        $specialization = $request->query('specialization');

        if (!$specialization) {
            return response()->json(['message' => 'Specialization parameter is required.'], 400);
        }

        // Pobieramy lekarzy z daną specjalizacją
        $doctors = Doctor::whereHas('specializations', function ($query) use ($specialization) {
            $query->where('name', $specialization);
        })->with('specializations')->get();

        // Sprawdzamy, czy znaleziono lekarzy
        if ($doctors->isEmpty()) {
            return response()->json(['message' => 'No doctors found with the specified specialization.'], 404);
        }

        // Formatujemy dane w odpowiednim formacie
        $result = $doctors->map(function ($doctor) {
            return [
                'doctor_id' => $doctor->doctor_id,
                'first_name' => $doctor->first_name,
                'last_name' => $doctor->last_name,
                'specializations' => $doctor->specializations->pluck('name')->toArray(),
            ];
        });

        return response()->json($result, 200);
    }
}
