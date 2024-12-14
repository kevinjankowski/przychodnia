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
}
