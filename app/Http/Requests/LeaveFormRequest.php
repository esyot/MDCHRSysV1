<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class LeaveFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'term_id' => ['nullable', 'integer'],
            'leave_type' => ['nullable', 'string', 'max:255'],
            'leave_type_option' => ['nullable', 'string', 'max:255'],
            'vacation_option' => ['nullable', 'string', 'max:255'],
            'convalescence_place' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'sick_type' => ['nullable', 'string', 'max:255'],
            'illness' => ['nullable', 'string', 'max:255'],
            'reason' => ['nullable', 'string'],
            'other_reason' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'class_description' => ['nullable', 'string'],
            'date_start' => ['required', 'date', 'before_or_equal:date_end'],
            'date_end' => ['required', 'date', 'after_or_equal:date_start'],
            'date_of_confinement' => ['nullable', 'before_or_equal:date_of_discharge'],
            'date_of_discharge' => ['nullable', 'after_or_equal:date_of_confinement'],
            'medical_certificate' => ['nullable'],
            'others' => ['nullable', 'integer', 'min:0'],

        ];
    }


}
