<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class PatientController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Patient::all());
    }

    public function addPatient(Request $request)
    {
        $validated = $request->validate([
            'pesel' => 'required|numeric|digits:11', // Pesel pacjenta
            'first_name' => 'required|min:3|max:32', // Sprawdzenie, czy lekarz istnieje
            'last_name' => 'required|min:3|max:64', // Sprawdzenie, czy godzina istnieje
        ]);

        // Sprawdzamy, czy pacjent istnieje
        $patient = Patient::where('pesel', $request->pesel)->first();

        if ($patient) {
            return response()->json(['message' => 'Patient with this PESEL already exists.'], 404);
        }

        $visit = Patient::create([
            'pesel' => $validated['pesel'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name']
        ]);

        // Zwracamy odpowiedź
        return response()->json([
            'message' => 'Patient successfully added.',
        ], 201);
    }
}
