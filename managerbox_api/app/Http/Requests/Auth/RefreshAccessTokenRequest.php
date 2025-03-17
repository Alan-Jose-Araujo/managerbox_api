<?php

namespace App\Http\Requests\Auth;

use App\Traits\Http\SendJsonResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RefreshAccessTokenRequest extends FormRequest
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
            'refresh_token' => ['required', 'string', 'min:64', 'max:64']
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
