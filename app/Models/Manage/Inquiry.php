<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Inquiry extends Model
{
    use Searchable;
    protected $table = 'inquiries';
    protected $guarded = [];
    protected $appends = ['category_name'];
    protected $casts = [
        'is_answer' => 'boolean'
    ];

    public function answers()
    {
        return $this->hasOne(InquiryAnswers::class);
    }

    public function category()
    {
        return $this->belongsTo(InquiryCategory::class, 'category_id', 'id');
    }

    public function getCategoryNameAttribute()
    {
        return InquiryCategory::find($this->category_id)->name;
    }

    public function toSearchableArray(){
        $array['id']  = $this->id;
        $array['title'] = $this->title;
        $array['content'] = $this->content;
        $array['category_id'] = $this->category_id;
        return $array;
    }
}
