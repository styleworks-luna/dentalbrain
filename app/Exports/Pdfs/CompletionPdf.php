<?php

namespace App\Exports\Pdfs;


use Barryvdh\DomPDF\Facade\Pdf;

class CompletionPdf extends CertificationPdf
{
    private $certification;
    private $profile;
    private $categories;
    private $staticImages;

    /**
     * @param $certification
     * @param $profile
     * @param $categoryName
     * @param PdfImages $pdfImages
     */
    public function __construct($certification, $profile, $categoryName, PdfImages $pdfImages)
    {
        $this->certification = $certification;
        $this->profile = $profile;

        // 협회 이름이 여러 개일 가능성이 있어서 ' '기준으로 나눠 배열에 담음
        $this->categories = explode(" ", $categoryName);
        $this->staticImages = $pdfImages->getStaticImages();
    }


    function getPdf(): \Barryvdh\DomPDF\PDF
    {
        Pdf::setOptions(['isFontSubsettingEnabled' => true]);
        return Pdf::loadView('pdfs.completion.completion_pdf', $this->getPdfArguments());
    }

    function getPdfArguments(): array
    {
        return [
            'certification' => $this->certification,
            'categories' => $this->categories,
            'profile' => $this->profile,
            'profile_image' => self::profileImageSrc($this->profile->file),
            'staticImages' => $this->staticImages,
        ];
    }

    function getFileName(): string
    {
        return sanitizeForFileName($this->profile->name . "_수료증.pdf");
    }
}
