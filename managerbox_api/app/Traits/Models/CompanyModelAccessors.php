<?php

namespace App\Traits\Models;

trait CompanyModelAccessors
{
    public function getLogoImagePathAttribute(): ?string
    {
        if(!property_exists($this, 'logo_image_path')) {
            return null;
        }

        if($this->logo_image_path) {
            return asset("storage/company_logos/$this->logo_image_path");
        }
    }
}
