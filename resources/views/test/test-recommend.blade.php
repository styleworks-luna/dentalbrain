@extends('desktop.layouts.frames.simple_frame')
@section('content')
    <section id="content" class="content">
        <br><br><br><br>
        <form action="" method="post">
            @csrf

            <span>추천 :</span>
            @foreach($recruits as $recruit)
                <br>
                <label for="{{$recruit->id}}">{{ $recruit->company_name }}</label>
                <input type="checkbox" name="recruits[]" value="{{ $recruit->id }}" id="{{ $recruit->id }}">
            @endforeach
            <br>
            <input type="submit">
        </form>
        <br>
        <br>
        <br><br><br><br><br><br><br><br>
    </section>
@endsection
