<?php

namespace App\Models\Payments;

use App\Models\Program\ProgramStudent;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $guarded = [];

    public function students(){
        return $this->hasMany(ProgramStudent::class, 'payment_id','id');
    }
}
