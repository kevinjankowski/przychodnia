<?php

namespace App\Http\Controllers;

use App\Models\Hour;
use App\Models\Specialization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HourController
{
    public function index(): JsonResponse
    {
        return response()->json(Hour::all());
    }

    public function getHourIdByTime(string $hour): ?int
    {
        // Znajdź rekord godziny na podstawie wartości "hour"
        $hourRecord = Hour::where('hour', $hour)->first();

        return $hourRecord ? $hourRecord->hour_id : null;
    }
}
