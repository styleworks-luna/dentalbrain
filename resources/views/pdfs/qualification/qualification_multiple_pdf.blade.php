@extends('pdfs.qualification.qualification_pdf_layout')

@section('content')
    <?php /** @var \App\Exports\Pdfs\CertificationPdf $pdf */ ?>
    @foreach($pdfList as $pdf)
        @include('pdfs.qualification.qualification_content',$pdf->getPdfArguments())
        @unless($loop->last)
            <div class="page-break"></div>
        @endunless
    @endforeach
@endsection
