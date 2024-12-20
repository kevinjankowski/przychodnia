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
    public function getVisitsByPesel(Request $request)
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

        if (!$doctorId) {
            return response()->json(['message' => 'Doctor ID is required.'], 400);
        }

        $doctor = Doctor::where('doctor_id', $doctorId)->first();

        if (!$doctor) {
            return response()->json(['message' => 'Doctor with this ID does not exists.'], 404);
        }

        // Pobierz wszystkie zajęte terminy dla danego lekarza
        $occupiedSlots = Visit::where('doctor_id', $doctorId)
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
            return response()->json(['message' => 'No occupied slots found for the specified doctor.'], 404);
        }

        // Zwróć wyniki w formacie JSON
        return response()->json($occupiedSlots, 200);
    }

    // --------------------------- POST ---------------------------

    // Dodawanie wizyty do istniejącego w bazie pacjenta
    public function addVisit(Request $request): \Illuminate\Http\JsonResponse
    {
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'patient_id' => 'required|numeric|digits:11', // Pesel pacjenta
            'doctor_id' => 'required|numeric|exists:doctors,doctor_id', // Sprawdzenie, czy lekarz istnieje
            'hour_id' => 'required|numeric|exists:hours,hour_id', // Sprawdzenie, czy godzina istnieje
            'date' => 'required|date_format:Y-m-d', // Sprawdzenie, czy data wizyty jest poprawna
            'note' => 'nullable|max:255',
        ]);

        // Sprawdzamy, czy pacjent istnieje
        $patient = Patient::where('pesel', $request->patient_id)->first();

        if (!$patient) {
            return response()->json(['message' => 'Patient with this PESEL not found.'], 404);
        }

        // Sprawdzamy, czy wybrana godzina nie jest już zajęta
        $existingVisit = Visit::where('doctor_id', $request->doctor_id)
            ->where('hour_id', $request->hour_id)
            ->where('date', $request->date)
            ->first();

        if ($existingVisit) {
            return response()->json(['message' => 'The selected time slot is already occupied.'], 400);
        }

        // Dodajemy nową wizytę
        $visit = Visit::create([
            'patient_id' => Patient::where('pesel', $validated['patient_id'])->first()->pesel,
            'doctor_id' => $validated['doctor_id'],
            'hour_id' => $validated['hour_id'],
            'date' => $validated['date'],
            'note' => $validated['note'],
        ]);

        // Zwracamy odpowiedź
        return response()->json([
            'message' => 'Visit successfully created.',
        ], 201);
    }

}
