<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    //

    protected $table = 'inquiries';
    protected $guarded = [];
    protected $appends = ['category_name'];
    protected $casts = [
        'is_answer' => 'boolean'
    ];

    public function answer()
    {
        return $this->hasOne(InquiryAnswer::class);
    }

    public function category()
    {
        return $this->belongsTo(InquiryCategory::class, 'category', 'id');
    }

    public function getCategoryNameAttribute()
    {
        return InquiryCategory::find($this->category_id)->name;
    }

}
