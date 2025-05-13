<?php

use App\Http\Controllers\Api\V1\PatientController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('access.key')->group(function () {
    Route::apiResource('patients', PatientController::class);
});