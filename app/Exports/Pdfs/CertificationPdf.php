<?php

namespace App\Exports\Pdfs;

use App\Models\File;
use Barryvdh\DomPDF\PDF;

abstract class CertificationPdf
{
    abstract function getPdf(): PDF;

    abstract function getPdfArguments(): array;

    abstract function getFileName(): string;

    /**
     * @param File|mixed|null $file
     * @return ?string
     */
    protected static function profileImageSrc($file): ?string
    {
        return $file != null ? "file://" . storage_path("app/" . $file->path) : null;
    }
}
