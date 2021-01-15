<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class InquiryAnswers extends Model
{
    //
    protected $table='inquiry_answers';
    protected $fillable = ['enquiry_id','display_name','title','content','user_id'];

    public function inquiry(){
        return $this->belongsTo(Inquiry::class,'id','enquiry_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'id','user_id');
    }
}