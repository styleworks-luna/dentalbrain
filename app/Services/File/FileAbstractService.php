<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-19
 * Time: 오후 4:22
 */

namespace App\Services\File;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;

abstract class FileAbstractService
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    abstract function fileDelete(Model $model);

    abstract function tempFileTransferToStorage(Model $model, File $file);

    /**
     * @param Model $model
     * @param array $parameter
     * @return string
     */
    abstract function getPersistenceFilePath($parameter = []);
}
