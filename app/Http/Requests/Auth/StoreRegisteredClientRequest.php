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
            'company_email' => ['required', 'string', 'max:255', 'email', 'unique:companies,email'],
            'company_cnpj' => ['required', 'string', 'size:14', 'unique:companies,cnpj', "regex:/\d/"],
            'company_state_registration' => ['required', 'string', 'size:9', 'unique:companies,state_registration', "regex:/\d/"],
            'company_foundation_date' => ['nullable', 'string', 'date_format:Y-m-d'],
            'company_landline' => ['nullable', 'string', 'size:8', "regex:/\d/"],
            'cnae_code' => ['required', 'string', 'min:6', 'max:7', 'exists:metiers,cnae_code', "regex:/\d/"],

            // User data.
            'user_name' => ['required', 'string', 'min:3', 'max:255', "regex:/^(?!.*\s{2})[A-Za-zÀ-ÖØ-öø-ÿ'’-]+(?:\s[A-Za-zÀ-ÖØ-öø-ÿ'’-]+)*$/i"],
            'user_email' => ['required', 'string', 'max:255', 'email', 'unique:users,email'],
            'user_password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'user_cpf' => ['required', 'string', 'size:11', 'unique:users,cpf', "regex:/\d/"],
            'user_phone_number' => ['nullable', 'string', 'size:9', "regex:/\d/"],
            'user_birth_date' => ['required', 'string', 'date_format:Y-m-d'],

            // Company address data.
            'company_address_street' => ['required', 'string', 'min:3', 'max:255'],
            'company_address_building_number' => ['required', 'string', 'min:2', 'max:5', "regex:/^\d+[A-Za-zºª\-\/\s]*$/"],
            'company_address_complement' => ['nullable', 'string', 'min:5', 'max:500'],
            'company_address_neighborhood' => ['required', 'string', 'min:3', 'max:255'],
            'company_address_city' => ['required', 'string', 'min:3', 'max:255', "regex:/\D/"],
            'company_address_state' => ['required', 'string', 'size:2', "regex:/\D/"],
            'company_address_zipcode' => ['required', 'string', 'size:8', "regex:/\d/"],
            'company_address_country' => ['required', 'string', 'size:2', "regex:/\D/"],

            'user_has_the_same_address_as_the_company' => ['nullable', 'boolean'],

            // User address data.
            'user_address_street' => ['prohibited_if:user_has_the_same_address_as_the_company,true', 'string', 'min:3', 'max:255'],
            'user_address_building_number' => ['prohibited_if:user_has_the_same_address_as_the_company,true', 'string', 'min:2', 'max:5', "regex:/^\d+[A-Za-zºª\-\/\s]*$/"],
            'user_address_complement' => ['nullable', 'string', 'min:5', 'max:500'],
            'user_address_neighborhood' => ['prohibited_if:user_has_the_same_address_as_the_company,true', 'string', 'min:3', 'max:255'],
            'user_address_city' => ['prohibited_if:user_has_the_same_address_as_the_company,true', 'string', 'min:3', 'max:255', "regex:/\D/"],
            'user_address_state' => ['prohibited_if:user_has_the_same_address_as_the_company,true', 'string', 'size:2', "regex:/\D/"],
            'user_address_zipcode' => ['prohibited_if:user_has_the_same_address_as_the_company,true', 'string', 'size:8', "regex:/\d/"],
            'user_address_country' => ['prohibited_if:user_has_the_same_address_as_the_company,true', 'string', 'size:2', "regex:/\D/"],
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
