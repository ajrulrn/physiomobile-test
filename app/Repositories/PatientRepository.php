<?php

namespace App\Repositories;

use App\Models\Patient;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientRepository
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return Patient::with('user')->orderBy('created_at', 'desc')->get();
    }

    public function getById($id)
    {
        return Patient::with('user')->where('id', $id)->first();
    }

    public function create($data)
    {
        DB::beginTransaction();

        try {
            $userPayload = $data;
            $userPayload['email'] = uniqid() . '@ajrulrn.my.id';
            $userPayload['password'] = Str::random(64);
            unset($userPayload['medium_acquisition']);
            $user = $this->userRepository->create($userPayload);
            $patientPayload = [
                'user_id' => $user->id,
                'medium_acquisition' => $data['medium_acquisition']
            ];
            $patient = Patient::create($patientPayload);
            DB::commit();
            return $patient;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $userPayload = $data;
            if ($data['medium_acquisition']) {
                unset($userPayload['medium_acquisition']);
                $patientPayload['medium_acquisition'] = $data['medium_acquisition'];
                $this->getById($id)->update($data);
            }
            $this->userRepository->update($id, $userPayload);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $patient = $this->getById($id);
            Patient::destroy($id);
            $this->userRepository->delete($patient->user_id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}