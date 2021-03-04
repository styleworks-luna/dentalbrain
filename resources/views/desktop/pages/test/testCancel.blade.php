@extends('desktop.layouts.app')

@section('frame')
    <section id="content">
        <br>
        {{ \Illuminate\Support\Facades\Auth::user()->name }}
        <br>
        <ul>
            @foreach($students as $student)
                @isset ($student->payment)
                <li>
                    <form method="POST">
                        <p>ID : {{$student->id }}</p>
                        <p>신청자 이름 :{{$student->user->name}}</p>
                        <p>결제수단 : {{$student->payment->method}}</p>
                        <p>강의 : {{ $student->ticket->program->is_online ? '온라인' : '오프라인' }}</p>
                        <p>강의 환불 가능 여부 :{{ $student->cancelAvailable() ? '가능' : '불가능'  }}</p>
                        @method('DELETE')
                        @csrf
                        reason
                        <input type="text" name="reason">
                        @if ($student->payment->method == '가상계좌')
                            bank
                        <input type="text" name="bank">
                            accountNumber
                        <input type="text" name="accountNumber">
                            holderName
                        <input type="text" name="holderName">
                        @endif
                        <input type="submit">
                    </form>
                </li>
                @endisset
                <br>
            @endforeach
        </ul>

    </section>
@endsection
