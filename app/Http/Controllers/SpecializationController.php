<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\JsonResponse;

class SpecializationController
{
    public function index(): JsonResponse
    {
        return response()->json(Specialization::all());
    }
}
