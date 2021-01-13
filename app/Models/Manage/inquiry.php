<?php

namespace App\Models\Manage;
;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    //
    protected $fillable = ['name','phone','email','title','content'];
}
