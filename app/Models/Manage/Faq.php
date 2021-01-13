<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faqs';

    protected $guarded = [];

    protected $appends = ['category_name'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id', 'id');
    }

    public function getCategoryNameAttribute()
    {
        return FaqCategory::find($this->attributes['category_id'])->name;
    }
}
