<?php

namespace App\Exports\Pdfs;

use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Collection;

abstract class CertificationPdf
{
    use HasPdfUtils;

    abstract function getPdf(): PDF;

    abstract function getPdfArguments(): array;

    protected function getStaticImages(): Collection
    {
        return collect([
            'certification_back' => $this->encodeToBase64DefaultImg('/images/admin/certification_back.png'),
            'KDMA_mark' => $this->encodeToBase64DefaultImg('/images/admin/KDMA_mark.svg'),
            'KDMA_light_mark' => $this->encodeToBase64DefaultImg('/images/admin/KDMA_light_mark.svg'),
            'sign' => $this->encodeToBase64DefaultImg('/images/admin/sign.png'),
        ]);
    }
}
