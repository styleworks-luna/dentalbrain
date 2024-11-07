<?php

namespace App\Exports\Pdfs;

use App\Models\Certificate\CertificateQualification;
use App\Models\Certificate\QualificationProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class QualificationPdf extends CertificationPdf
{
    private $certification;
    private $profile;
    private $categories;
    /**
     * @var array
     */
    private $staticImages;

    /**
     * @param CertificateQualification|Model|Builder $certification
     * @param QualificationProfile|Model|Builder $profile 프로필 사진 꼭 갖고있어야 함.
     * @param string $categoryName
     */
    public function __construct($certification, $profile, $categoryName, PdfImages $pdfImages)
    {
        $this->certification = $certification;
        $this->profile = $profile;

        // 협회 이름이 여러 개일 가능성이 있어서 ' '기준으로 나눠 배열에 담음
        $this->categories = explode("/", $categoryName);
        $this->staticImages = $pdfImages->getStaticImages();
    }

    public function getPdf(): \Barryvdh\DomPDF\PDF
    {
        Pdf::setOptions(['isFontSubsettingEnabled' => true]);
        return Pdf::loadView('pdfs.qualification.qualification_pdf', $this->getPdfArguments());
    }

    public function getPdfArguments(): array
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
        return sanitizeForFileName($this->profile->name . "_자격증.pdf");
    }
}
