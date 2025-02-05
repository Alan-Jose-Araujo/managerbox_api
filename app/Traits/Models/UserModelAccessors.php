<?php

namespace App\Traits\Models;

trait UserModelAccessors
{
    public function getProfilePicturePathAttribute(): string
    {
        if(property_exists($this, 'profile_picture_path')) {
            return asset("storage/profile_pictures/$this->profile_picture_path");
        }

        return asset("storage/standards/standard_user_profile_picture.png");
    }
}
