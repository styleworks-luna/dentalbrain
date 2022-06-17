<?php

namespace App\Exports\Pdfs;

use App\Models\File;

trait HasPdfUtils
{
    protected function encodeToBase64DefaultImg($imgPath): string
    {
        $path = public_path($imgPath);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    protected function encodeToBase64(File $file): string
    {
        $path = storage_path('app/' . $file->path);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
