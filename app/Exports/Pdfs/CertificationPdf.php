<?php

namespace App\Exports\Pdfs;

use App\Models\File;
use Barryvdh\DomPDF\PDF;

abstract class CertificationPdf
{
    abstract function getPdf(): PDF;

    abstract function getPdfArguments(): array;

    abstract function getFileName(): string;

    protected static function encodeToBase64(File $file): string
    {
        $path = storage_path('app/' . $file->path);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
