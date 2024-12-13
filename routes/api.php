<?php

use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Pacjenci
Route::get('/patients', [PatientController::class, 'index']); // Lista pacjentów
Route::post('/patients', [PatientController::class, 'addPatient']); // Dodanie pacjenta

// Lekarze
Route::get('/doctors', [DoctorController::class, 'index']); // Lista lekarzy z ich specjalizacjami


// Wizyty
Route::get('/visits', [VisitController::class, 'getVisitsByPesel']); // Pobieranie wizyty za pomocą peselu
Route::post('/visits', [VisitController::class, 'addVisit']); // Dodawanie wizyty

