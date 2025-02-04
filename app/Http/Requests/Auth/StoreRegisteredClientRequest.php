<?php

namespace App\Http\Requests\Auth;

use App\Traits\Http\SendJsonResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

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
            'company_fantasy_name' => ['required', 'string', 'min:3', 'max:255', "regex:/[\p{L}0-9&.,'()\-\s]+/"],
            'company_corporate_reason' => ['required', 'string', 'min:4', 'max:255', "regex:/[\p{L}0-9&.,'()\-\s]+/"],
            'company_email' => ['required', 'string', 'email', 'max:255'],
            'company_cnpj' => ['required', 'string', 'min:14', 'max:14'],
            'company_state_registration' => ['required', 'string', 'min:9', 'max:9', "regex:/\d{9}/"],
            'company_foundation_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'company_landline' => ['nullable', 'string', 'min:8', 'max:8', "regex:/\d{8}/"],

            // User data.
            'user_name' => ['required', 'string', 'min:3', 'max:255', "regex:/(?!.*\s{2})[A-ZÁÀÂÃÉÈÍÏÓÔÕÖÚÜÑa-záàâãéèíïóôõöúüñ.'’\-]{2,100}/"],
            'user_email' => ['required', 'string', 'email', 'max:255'],
            'user_password' => ['required', 'string', 'min:8', 'max:255'],
            'user_user_cpf' => ['required', 'string', 'min:11', 'max:11', "regex:/\d{11}/"],
            'user_phone_number' => ['required', 'string', 'min:9', 'max:9', "regex:/\d{9}/"],

            // Company address data.
            'company_address_street' => ['required', 'string', 'min:3', 'max:255'],
            'company_address_building_number' => ['required', 'string', 'min:2', 'max:5'],
            'company_address_complement' => ['nullable', 'string', 'min:3', 'max:500'],
            'company_address_neighborhood' => ['required', 'string', 'min:3', 'max:255'],
            'company_address_city' => ['required', 'string', 'min:4', 'max:255'],
            'company_address_state' => ['required', 'string', 'min:2', 'max:2', "regex:/\D{2}/"],
            'company_address_zipcode' => ['required', 'string', 'min:8', 'max:8', "regex:/\d{8}/"],
            'company_address_country' => ['required', 'string', 'min:2', 'max:2', "regex:/\D{2}/"],

            'user_wants_to_register_address' => ['nullable', 'boolean'],

            // User address data.
            'user_address_street' => ['required_if:user_wants_to_register_address,true', 'string', 'min:3', 'max:255'],
            'user_address_building_number' => ['required_if:user_wants_to_register_address,true', 'string', 'min:2', 'max:5'],
            'user_address_complement' => ['nullable', 'string', 'min:3', 'max:500'],
            'user_address_neighborhood' => ['required_if:user_wants_to_register_address,true', 'string', 'min:3', 'max:255'],
            'user_address_city' => ['required_if:user_wants_to_register_address,true', 'string', 'min:4', 'max:255'],
            'user_address_state' => ['required_if:user_wants_to_register_address,true', 'string', 'min:2', 'max:2', "regex:/\D{2}/"],
            'user_address_zipcode' => ['required_if:user_wants_to_register_address,true', 'string', 'min:8', 'max:8', "regex:/\d{8}/"],
            'user_address_country' => ['required_if:user_wants_to_register_address,true', 'string', 'min:2', 'max:2', "regex:/\D{2}/"],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return $this->sendBadRequestResponse(
            'Bad Request',
            $validator->errors()->toArray(),
        );
    }
}
