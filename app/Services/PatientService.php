<?php

namespace App\Services;

use App\Repositories\PatientRepository;
use Exception;

class PatientService
{
    protected $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function getAll()
    {
        return $this->patientRepository->getAll();
    }

    public function getById($id)
    {
        return $this->patientRepository->getById($id);
    }

    public function create($data)
    {
        try {
            return $this->patientRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('failed to create patient: ' . $e->getMessage());
        }
    }

    public function update($id, $data)
    {
        $patient = $this->getById($id);

        if (!$patient) {
            return false;
        }

        try {
            $this->patientRepository->update($id, $data);
            return true;
        } catch (Exception $e) {
            throw new Exception('failed to update patient: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $patient = $this->getById($id);

        if (!$patient) {
            return false;
        }

        try {
            $this->patientRepository->delete($id);
            return true;
        } catch (Exception $e) {
            throw new Exception('failed to delete patient: ' . $e->getMessage());
        }
    }
}