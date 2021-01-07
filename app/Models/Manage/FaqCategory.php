<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $table = 'faq_categories';

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id', 'id');
    }
}
