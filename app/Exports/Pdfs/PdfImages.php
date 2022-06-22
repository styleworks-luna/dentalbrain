<?php

namespace App\Exports\Pdfs;

use App\Models\File;

class PdfImages
{
    private $certification_back;
    private $kdma_mark;
    private $kdma_light_mark;
    private $sign;

    /**
     */
    public function __construct()
    {
        $this->certification_back = "file://" . public_path("/images/admin/certification_back.jpg");
        $this->kdma_mark = "file://" . public_path("/images/admin/KDMA_mark.jpg");
        $this->kdma_light_mark = "file://" . public_path("/images/admin/KDMA_light_mark.jpg");
        $this->sign = "file://" . public_path("/images/admin/sign.jpg");
    }

    private static function encodeToBase64DefaultImg($imgPath): string
    {
        $path = public_path($imgPath);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public function getStaticImages(): array
    {
        return [
            'certification_back' => $this->certification_back,
            'KDMA_mark' => $this->kdma_mark,
            'KDMA_light_mark' => $this->kdma_light_mark,
            'sign' => $this->sign,
        ];
    }
}
