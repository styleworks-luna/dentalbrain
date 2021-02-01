<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
/**
 * @method static Builder public ()
 */
class Faq extends Model
{
    protected $table = 'faqs';

    protected $appends = ['category_name'];

    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id', 'id');
    }

    public function getCategoryNameAttribute()
    {
        return FaqCategory::find($this->attributes['category_id'])->name;
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopePublic($query){
        return $query->where('is_open','1')->orderBy('id','desc');
    }
}
