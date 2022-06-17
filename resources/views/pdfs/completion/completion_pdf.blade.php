@extends('pdfs.completion.completion_pdf_layout')

@section('content')
    @include('pdfs.completion.completion_pdf_content',[
        'certification' => $certification,
        'categories' => $categories,
        'profile' => $profile,
        'profile_image' => $profile_image,
        'staticImages' => $staticImages,
    ])
@endsection
