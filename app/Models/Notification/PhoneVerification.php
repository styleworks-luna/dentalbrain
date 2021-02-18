<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Model;

class PhoneVerification extends Model
{
    protected $tables='phone_verifications';
    protected $guards = [];
}
