<table>
    <thead>
    <tr>
        <th>번호</th>
        <th>이름</th>
        <th>아이디</th>
        <th>이메일</th>
        <th>연락처</th>
        <th>결제금액</th>
        <th>시청기간</th>
        <th>신청일시</th>
        @foreach($surveys as $survey)
            @if ($survey->category_id == 2)
                {{--다중 선택--}}
                <th colspan="{{ $survey->choices_count }}">
                    {{$survey->question}}
                </th>
            @else
                <th>{{$survey->question}}</th>
            @endif
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->user->name }}</td>
            <td>{{ $student->user->login_id }}</td>
            <td>{{ $student->user->email }}</td>
            <td>{{ $student->user->phone }}</td>
            <td>{{ $student->payment ? $student->payment->totalAmount : '미결제' }}</td>
            <td>{{ $student->left_days }}</td>
            <td>{{ $student->applied_at }}</td>
            @foreach($surveys as $survey)
                @if($survey->category_id == 2)
                    {{--다중 선택--}}
                    @foreach($survey->choices as $choice)
                        @if ($surveyAnswers->where('user_id',$student->user->id)->where('choice_id',$choice->id)->isNotEmpty())
                            <td>{{ $surveyAnswers->where('user_id',$student->user->id)->where('choice_id',$choice->id)->first()->content }}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                @elseif($survey->category_id == 4)
                    @if ($surveyAnswers->where('user_id',$student->user->id)->where('survey_id',$survey->id)->isNotEmpty())
                        <td>
                            {{ $surveyAnswers->where('user_id',$student->user->id)->where('survey_id',$survey->id)->first()->address }}
                            ,
                            {{ $surveyAnswers->where('user_id',$student->user->id)->where('survey_id',$survey->id)->first()->address_detail }}
                        </td>
                    @else
                        <td></td>
                    @endif
                @elseif($survey->category_id == 5)
                    @if ($surveyAnswers->where('user_id',$student->user->id)->where('survey_id',$survey->id)->isNotEmpty())
                        <td>
                            {{ $surveyAnswers->where('user_id',$student->user->id)->where('survey_id',$survey->id)->first()->file->name }}
                        </td>
                    @else
                        <td></td>
                    @endif
                @else
                    @if ($surveyAnswers->where('user_id',$student->user->id)->where('survey_id',$survey->id)->isNotEmpty())
                        <td>
                            {{ $surveyAnswers->where('user_id',$student->user->id)->where('survey_id',$survey->id)->first()->content }}
                        </td>
                    @else
                        <td></td>
                    @endif
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
