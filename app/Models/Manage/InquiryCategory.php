<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class InquiryCategory extends Model
{
    protected $table = 'inquiry_categories';

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'category_id', 'id');
    }
}
