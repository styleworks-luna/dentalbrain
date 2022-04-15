<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;

class ResumeExportPdf implements \Maatwebsite\Excel\Concerns\FromView
{
    private $resume;
    private $leftList;
    private $rightList;
    private $categories;

    /**
     * @param $resume
     * @param $leftList
     * @param $rightList
     * @param $categories
     */
    public function __construct($resume, $leftList, $rightList, $categories)
    {
        $this->resume = $resume;
        $this->leftList = $leftList;
        $this->rightList = $rightList;
        $this->categories = $categories;
    }


    /**
     * @inheritDoc
     */
    public function view(): View
    {
        return view('pdfs.resume_pdf', [
            'resume' => $this->resume,
            'leftList' => $this->leftList,
            'rightList' => $this->rightList,
            'categories' => $this->categories,
        ]);
    }
}
