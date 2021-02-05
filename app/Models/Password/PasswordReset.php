<?php

namespace App\Models\Password;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordReset extends Model
{
    use softDeletes;
    protected $table = 'password_resets';
    protected $guards=[];
}
