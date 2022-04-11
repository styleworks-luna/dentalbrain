<?php

namespace App\Models\Recruit;

use Illuminate\Database\Eloquent\Model;

class RecruitPrice extends Model
{
    // hasMembership
    static $HAS_NOT_MEMBERSHIP = 1;
    static $HAS_MEMBERSHIP = 2;

}