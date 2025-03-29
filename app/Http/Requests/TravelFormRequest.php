<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        return [
            'term_id' => ['nullable'],
            'date_start' => ['required', 'date', 'before_or_equal:date_end'],
            'date_end' => ['required', 'date', 'after_or_equal:date_start'],
            'destination' => ['required', 'string', 'max:255'],
            'purpose' => ['required', 'string'],
            'contact_person' => ['required', 'string', 'max:255'],
            'contact_person_no' => ['required', 'string', 'max:15'],
            'amount' => ['required', 'numeric', 'min:0'],
            'budget_type' => ['required', 'string', 'max:255'],
            'budget_charged_to' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'class_description' => ['nullable', 'string'],
        ];

    }


}
