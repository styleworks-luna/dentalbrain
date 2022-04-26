<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $pg_id
 * @property string $pg_type
 */
class Payment extends Model
{
    public function pg() {
        $this->morphTo();
    }
}
