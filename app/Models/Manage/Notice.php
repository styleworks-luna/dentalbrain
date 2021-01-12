<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Notice extends Model
{
    protected $appends = ['name'];
    protected $fillable = ['title','content','display_name','user_id'];

    public function getNameAttribute()
    {
        return $this->attributes['display_name'] ?? '관리자';
    }

    public function owner(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
