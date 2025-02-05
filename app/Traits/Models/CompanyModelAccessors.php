<?php

namespace App\Traits\Models;

trait CompanyModelAccessors
{
    public function getLogoImagePathAttribute(): string
    {
        if($this->logo_image_path) {
            return asset("storage/company_logos/$this->logo_image_path");
        }
    }
}
