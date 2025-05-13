<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $patient = $this->route('patient');
        $userId = optional($patient)->user_id;
        return [
            'name' => 'sometimes|required|string|max:255',
            'id_type' => 'sometimes|required|string',
            'id_no' => [
                'sometimes',
                'required',
                'string',
                Rule::unique('users')->ignore($userId)
            ],
            'gender' => 'sometimes|required|in:male,female',
            'dob' => 'sometimes|required|date|date_format:Y-m-d',
            'address' => 'sometimes|required|string',
            'medium_acquisition' => 'sometimes|required|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'validation error',
            'errors' => $validator->errors()
        ], 422));
    }
}
