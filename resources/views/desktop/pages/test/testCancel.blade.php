@extends('desktop.layouts.app')

@section('frame')
    <section id="content">
        <ul>
            @foreach($students as $student)
                <li>
                    <form
                        action="{{ route('api.admin.lecture.online.students.cancel',['student' => $student,'program' => $student->ticket->program,]) }}"
                        method="POST"
                    >
                        <p>{{$student->id }}</p>
                        <p>{{$student->user->name}}</p>
                        @method('DELETE')
                        @csrf
                        <input type="text" name="reason">
                        <input type="submit">
                    </form>
                </li>
                <br>
            @endforeach
        </ul>

    </section>
@endsection
