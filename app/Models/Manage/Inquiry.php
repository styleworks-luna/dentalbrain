<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    //
    protected $table = 'inquiries';
    protected $fillable = ['name','phone','email','title','content'];

    public function answers(){
        return $this->hasOne(Inquiry_answers::class);
    }
}
