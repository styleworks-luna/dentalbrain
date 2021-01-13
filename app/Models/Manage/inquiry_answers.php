<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquiry_answers extends Model
{
    //
    protected $fillable = ['enquiry_id','display_name','title','content','user_id'];
}
