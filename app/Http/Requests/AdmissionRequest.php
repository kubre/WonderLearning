<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @todo Make sure to properly authorize people */
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "photo" => "nullable",
            "admission_at" => "required",
            "created_at" => "required",
            "name" => "required",
            "gender" => "required",
            "code" => "required|integer",
            "dob_at" => "required|date|before:today",
            "nationality" => "required",
            "program" => "required",
            "father_name" => "required_without:mother_name",
            "father_email" => "required_without:mother_email",
            "father_contact" => "required_without:mother_contact",
            "father_occupation" => "nullable",
            "father_organization" => "nullable",
            "mother_name" => "required_without:father_name",
            "mother_email" => "required_without:father_email",
            "mother_contact" => "required_without:father_contact",
            "mother_occupation" => "nullable",
            "mother_organization" => "nullable",
            "address" => "required|max:191",
            "city" => "required",
            "state" => "required",
            "pincode" => "nullable|digits:6",
            "discount" => "numeric|min:0",
            "batch" => "required|in:Morning,Afternoon",
            "is_transportation_required" => "boolean",
            "siblings" => "nullable",
            'is_graduation' => 'nullable',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'dob_at.before' => 'Date of Birth should not be today or after',
        ];
    }
}
