<?php
namespace App\Services\ViewCount;

use Illuminate\Database\Eloquent\Model;

interface ViewCountMethod {
    public function viewCountAdd(Model $model);
}
?>
