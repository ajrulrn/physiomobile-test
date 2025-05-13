<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Services\PatientService;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function index()
    {
        $patients = $this->patientService->getAll();
        return response()->json([
            'status' => true,
            'data' => [
                'patients' => $patients
            ]
        ]);
    }

    public function show($id)
    {
        $patient = $this->patientService->getById($id);

        if (!$patient) {
            return response()->json([
                'status' => false,
                'message' => 'patient not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'patient' => $patient
            ]
        ]);
    }

    public function store(StorePatientRequest $request)
    {
        try {
            $patient = $this->patientService->create($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'patient has been added',
                'data' => $patient
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'failed to create patient',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdatePatientRequest $request, $id)
    {
        try {
            $result = $this->patientService->update($id, $request->validated());

            if (!$result) {
                return response()->json([
                    'status' => false,
                    'message' => 'patient not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'patient has been updated'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'failed to update patient',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->patientService->delete($id);

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'patient not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'patient has been deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'failed to delete patient',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
