<?php
namespace App\Interfaces\ViewCount;

use Illuminate\Database\Eloquent\Model;
interface ViewCountMethod {
    public function viewCountAdd(Model $model);
}
?>
