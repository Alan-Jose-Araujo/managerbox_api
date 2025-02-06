<?php

namespace App\Http\Requests\Auth;

use App\Traits\Http\SendJsonResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreRegisteredClientRequest extends FormRequest
{
    use SendJsonResponses;

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
        return [
            // Company data.
            'company_fantasy_name' => ['required', 'string', 'min:3', 'max:255', "regex:/^[\p{L}0-9&.,'’\"()\-\s]+$/i"],
            'company_corporate_reason' => ['required', 'string', 'min:4', 'max:255', "regex:/^[\p{L}0-9&.,'’\-\s]+$/i"],
            'company_email' => ['required', 'string', 'email', 'max:255', 'unique:companies,email'],
            'company_cnpj' => ['required', 'string', 'min:14', 'max:14', 'unique:companies,cnpj', "regex:/\d{14}/"],
            'company_state_registration' => ['required', 'string', 'min:9', 'max:9', 'unique:companies,state_registration', "regex:/\d{9}/"],
            'company_foundation_date' => ['nullable', 'string', 'date_format:Y-m-d'],
            'company_landline' => ['nullable', 'string', 'min:8', 'max:8', "regex:/\d{8}/"],

            // User data.
            'user_name' => ['required', 'string', 'min:3', 'max:255', "regex:/^(?!.*\s{2})[A-Za-zÀ-ÖØ-öø-ÿ'’-]+(?:\s[A-Za-zÀ-ÖØ-öø-ÿ'’-]+)*$/i"],
            'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'user_password' => ['required', 'string', 'min:8', 'max:255'],
            'user_cpf' => ['required', 'string', 'min:11', 'max:11', 'unique:users,cpf', "regex:/\d{11}/"],
            'user_phone_number' => ['nullable', 'string', 'min:11', 'max:11', "regex:/\d{11}/"],
            'user_birth_date' => ['nullable', 'string', 'date_format:Y-m-d', Rule::date()->beforeOrEqual(now()->
            subYears(config('privacy.minimum_age')))],

            // Company address data.
            'company_address_street' => ['required', 'string', 'min:3', 'max:255'],
            'company_address_building_number' => ['required', 'string', 'min:2', 'max:5', "regex:/^\d+[A-Za-zºª\-\/\s]*$/"],
            'company_address_complement' => ['nullable', 'string', 'min:5', 'max:500'],
            'company_address_neighborhood' => ['required', 'string', 'min:3', 'max:255'],
            'company_address_city' => ['required', 'string', 'min:3', 'max:255'],
            'company_address_state' => ['required', 'string', 'min:2', 'max:2'],
            'company_address_zipcode' => ['required', 'string', 'min:8', 'max:8', "regex:/\d{8}/"],
            'company_address_country' => ['required', 'string', 'min:2', 'max:2', "regex:/\D{2}/"],

            'user_has_the_same_address_as_the_company' => ['nullable', 'boolean'],

            // User address data.
            'user_address_street' => ['required_if:user_has_the_same_address_as_the_company,false', 'string', 'min:3', 'max:255', "regex:/^[\p{L}0-9\s.,'’\-ºª]+$/u"],
            'user_address_building_number' => ['required_if:user_has_the_same_address_as_the_company,false', 'string', 'min:2', 'max:5', "regex:/^\d+[A-Za-zºª\-\/\s]*$/"],
            'user_address_complement' => ['nullable', 'string', 'min:5', 'max:500'],
            'user_address_neighborhood' => ['required_if:user_has_the_same_address_as_the_company,false', 'string', 'min:3', 'max:255'],
            'user_address_city' => ['required_if:user_has_the_same_address_as_the_company,false', 'string', 'min:3', 'max:255'],
            'user_address_state' => ['required_if:user_has_the_same_address_as_the_company,false', 'string', 'min:2', 'max:2'],
            'user_address_zipcode' => ['required_if:user_has_the_same_address_as_the_company,false', 'string', 'min:8', 'max:8', "regex:/\d{8}/"],
            'user_address_country' => ['required_if:user_has_the_same_address_as_the_company,false', 'string', 'min:2', 'max:2', "regex:/\D{2}/"],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->sendBadRequestResponse(
            'Bad Request',
            $validator->errors()->toArray(),
        ));
    }

    public function messages()
    {
        return [
            'user_birth_date.before_or_equal' => 'You must be at least ' . config('privacy.minimum_age') . ' years old to access the system'
        ];
    }
}
