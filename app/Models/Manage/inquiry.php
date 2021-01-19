<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    //
    protected $table = 'inquiries';
    protected $fillable = ['name','phone','email','title','content'];
    protected $casts =[
        'is_answer' => 'boolean'
    ];

    public function answers(){
        return $this->hasOne(InquiryAnswers::class);
    }
}
