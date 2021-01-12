<?php
namespace App\Interfaces\ViewCount;

use Illuminate\Database\Eloquent\Model;
interface InterfaceViewCountMethod {
    public function viewCountAdd(string $modelName,int $id);
}
?>
