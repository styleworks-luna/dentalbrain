<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ABILITIES</title>
    <style>
        table,
        td {
            border: 1px solid #333;
        }

        thead,
        tfoot {
            background-color: #555;
            color: #fff;
        }
    </style>

</head>
<body>
<form action="{{ route('postAbilities') }}" method="post" enctype="application/x-www-form-urlencoded">
    @csrf
    <table>
        <thead>
        <tr>
            <th colspan="2">구분</th>
            <th>점수</th>
            <th>가능</th>
        </tr>
        </thead>

        <tbody>
        @foreach($list as $category)
            @foreach($category->abilities as $ability)
                <tr>
                    @if($loop->first)
                        <td rowspan="{{ $loop->count }}">{{ $category->name }}</td>
                    @endif
                    <td>{{ $ability->name }}</td>
                    @if($ability->type == 'select')
                        <td>
                            <select name="{{ $ability->input_name . '_score'}}" id="">
                                <option value="0">선택</option>
                                <option value="1">경험없음</option>
                                <option value="2">미흡</option>
                                <option value="3">보통</option>
                                <option value="4">잘함</option>
                                <option value="5">매우잘함</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="{{ $ability->input_name . '_can_learn' }}" value="0">
                            <input type="checkbox" name="{{ $ability->input_name . '_can_learn' }}" value="1">
                        </td>
                    @else
                        <td colspan="2">
                            <input type="text" name="{{ $ability->input_name . '_content' }}">
                        </td>
                    @endif

                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
    <input type="submit">
</form>
</body>

</html>
