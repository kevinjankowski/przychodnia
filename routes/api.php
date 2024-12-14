<?php

use App\Http\Controllers\HourController;
use App\Http\Controllers\SpecializationController;
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
Route::get('/doctorsBySpec', [DoctorController::class, 'getDoctorsBySpec']); // Lista lekarzy o podanej specjalizacji

// Wizyty
Route::get('/visits', [VisitController::class, 'getVisitsByPesel']); // Pobieranie wizyty za pomocą peselu
Route::post('/visits', [VisitController::class, 'addVisit']); // Dodawanie wizyty
Route::get('/busyAppointments', [VisitController::class, 'getBusyAppointments']); // Pobieranie zajętych terminów danego lekarza

// Specjalizacje
Route::get('/specs', [SpecializationController::class, 'index']); // Lista pacjentów

// Godziny
Route::get('/hours', [HourController::class, 'index']); // Lista godzin wizyt
