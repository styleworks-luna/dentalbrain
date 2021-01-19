<?php

namespace App\Models\Manage;

use App\Models\Manage\Inquiry;
use Illuminate\Database\Eloquent\Model;

class InquiryCategory extends Model
{
    protected $table = 'inquiry_categories';

    public function Inquiries()
    {
        return $this->hasMany(Inquiry::class, 'category', 'id');
    }
}
