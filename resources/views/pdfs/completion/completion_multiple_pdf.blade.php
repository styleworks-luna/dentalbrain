@extends('pdfs.completion.completion_pdf_layout')

@section('content')
    <?php /** @var \App\Exports\Pdfs\CertificationPdf $pdf */ ?>
    @foreach($pdfList as $pdf)
        @include('pdfs.completion.completion_pdf_content',$pdf->getPdfArguments())
        @unless($loop->last)
            <div class="page-break"></div>
        @endunless
    @endforeach
@endsection
