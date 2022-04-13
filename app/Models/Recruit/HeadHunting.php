<?php

namespace App\Models\Recruit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadHunting extends Model
{
    use SoftDeletes;

    protected $table = 'head_hunting';
    protected $guarded = [];
}
