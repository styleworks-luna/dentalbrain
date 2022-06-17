@extends('pdfs.qualification.qualification_pdf_layout')

@section('content')
    @include('pdfs.qualification.qualification_content',[
        'certification' => $certification,
        'categories' => $categories,
        'profile' => $profile,
        'profile_image' => $profile_image,
        'staticImages' => $staticImages,
    ])
@endsection
