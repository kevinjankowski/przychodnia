<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DangerousController
{
    /*
    Jest to kontroler, w którym nie ma zabezpieczeń przed SQL Injection. Ma on za zadanie zaprezentować działanie
    ataków tego typu.

    Przykład wstrzyknięcia SQL, który w efekcie wyświetlającego wrażliwe dane pacjentów:
    http://127.0.0.1:8000/api/dangerous?doctor_id=1%20OR%201=1;
    http://127.0.0.1:8000/api/dangerous?doctor_id=1 or 1=1;INSERT INTO hours (hour_id, hour) VALUES (NULL, '12:30:00')
    */

    public function getPatientById(Request $request): \Illuminate\Http\JsonResponse
    {
        // Pobieranie wartości doctor_id z parametrów zapytania
        $pesel = $request->input('pesel');

        // Zapytanie w formie surowego SQL bez zabezpieczeń
        $query = "SELECT * FROM patients WHERE pesel = pesel";

        $expressionString = DB::raw($query)->getValue(DB::connection()->getQueryGrammar());

        // Wykonanie zapytania
        $results = DB::select($expressionString);

        // Zwrócenie wyników w formacie JSON
        return response()->json($results);
    }

}
