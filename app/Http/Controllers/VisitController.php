<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hour;
use App\Models\Patient;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VisitController extends Controller
{
    // --------------------------- GET ---------------------------

    // Pobieranie wszystkich wizyt danego pacjenta za pomocą jego peselu
    public function getVisitsByPesel(Request $request): \Illuminate\Http\JsonResponse
    {
        $pesel = $request->input('pesel');

        $patient = Patient::where('pesel', $pesel)->first();

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $visits = Visit::where('patient_id', $patient->pesel)
            ->with(['doctor', 'hour'])
            ->get();

        $response = $visits->map(function ($visit) {
            return [
                'visit_id' => $visit->visit_id,
                'date' => $visit->date,
                'time' => $visit->hour->hour, // Pobiera wartość z tabeli `hours`
                'doctor' => [
                    'first_name' => $visit->doctor->first_name,
                    'last_name' => $visit->doctor->last_name,
                    'specializations' => $visit->doctor->specializations->pluck('name')->toArray(),
                ],
                'note' => $visit->note,
            ];
        });

        return response()->json($response);
    }

    public function getBusyAppointments(Request $request): \Illuminate\Http\JsonResponse
    {
        // Pobierz ID lekarza z parametru zapytania
        $doctorId = $request->query('doctorId');
        $date = $request->query('date'); // Pobierz datę z parametru zapytania

        if (!$doctorId) {
            return response()->json(['message' => 'Doctor ID is required.'], 400);
        }

        if (!$date) {
            return response()->json(['message' => 'Date is required.'], 400);
        }

        $doctor = Doctor::where('doctor_id', $doctorId)->first();

        if (!$doctor) {
            return response()->json(['message' => 'Doctor with this ID does not exist.'], 404);
        }

        // Pobierz zajęte terminy dla danego lekarza i określonego dnia
        $occupiedSlots = Visit::where('doctor_id', $doctorId)
            ->where('date', $date) // Filtruj po dacie
            ->with('hour') // Dołącz dane godziny
            ->get(['date', 'hour_id']) // Pobierz tylko potrzebne dane
            ->map(function ($visit) {
                return [
                    'date' => $visit->date,
                    'hour' => $visit->hour->hour, // Z relacji "hour" pobieramy pole "hour"
                ];
            });

        // Sprawdź, czy znaleziono zajęte terminy
        if ($occupiedSlots->isEmpty()) {
            return response()->json(['message' => 'No occupied slots found for the specified doctor and date.'], 404);
        }

        // Zwróć wyniki w formacie JSON
        return response()->json($occupiedSlots, 200);
    }

    // --------------------------- POST ---------------------------

    // Dodawanie wizyty do istniejącego w bazie pacjenta
    public function addVisit(Request $request, HourController $hourController): \Illuminate\Http\JsonResponse
    {
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'patient_id' => 'required|numeric|digits:11', // PESEL pacjenta
            'doctor_id' => 'required|numeric|exists:doctors,doctor_id', // Sprawdzenie, czy lekarz istnieje
            'hour' => 'required|date_format:H:i:s', // Sprawdzenie formatu godziny
            'date' => 'required|date_format:Y-m-d', // Sprawdzenie formatu daty
            'note' => 'nullable|max:255',
        ]);

        // Pobierz ID godziny za pomocą HourController
        $hourId = $hourController->getHourIdByTime($validated['hour']);

        if (!$hourId) {
            return response()->json([
                'message' => 'The specified hour does not exist.',
                'status' => 405,
            ], 404);
        }

        // Sprawdź, czy pacjent istnieje
        $patient = Patient::where('pesel', $validated['patient_id'])->first();

        if (!$patient) {
            return response()->json([
                'message' => 'Patient with this PESEL not found.',
                'status' => 404,
            ], 404);
        }

        // Sprawdź, czy wybrana godzina i data nie są już zajęte
        $existingVisit = Visit::where('doctor_id', $validated['doctor_id'])
            ->where('hour_id', $hourId)
            ->where('date', $validated['date'])
            ->first();

        if ($existingVisit) {
            return response()->json([
                'message' => 'The selected time slot is already occupied.',
                'status' => 400
            ], 400);
        }

        // Dodaj nową wizytę
        $visit = Visit::create([
            'patient_id' => $patient->pesel,
            'doctor_id' => $validated['doctor_id'],
            'hour_id' => $hourId,
            'date' => $validated['date'],
            'note' => $validated['note'],
        ]);

        // Zwróć odpowiedź
        return response()->json([
            'message' => 'Visit successfully created.',
            'status' => 201
        ], 201);
    }

}
