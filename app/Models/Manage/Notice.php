<?php

namespace App\Models\Manage;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $appends = ['name'];
    protected $guarded = [];
    protected $casts = [
        'is_open' => 'boolean'
    ];

    public function getNameAttribute()
    {
        return $this->attributes['display_name'] ?? '관리자';
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
