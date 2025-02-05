<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fantasy_name' => $this->fantasy_name,
            'corporate_reason' => $this->corporate_reason,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'cnpj' => $this->cnpj,
            'state_registration' => $this->state_registration,
            'logo_image_path' => $this->logo_image_path,
            'foundation_date' => $this->foundation_date,
            'landline' => $this->landline,
            'is_active' => $this->is_active,
            'timezone' => $this->timezone,
            'currency_code' => $this->currency_code,
            'currency_decimal_places' => $this->currency_decimal_places,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
