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
    <table style="float:left;">
        <thead>
        <tr>
            <th colspan="2">구분</th>
            <th>점수</th>
            <th>가능</th>
        </tr>
        </thead>

        <tbody>
        @foreach($leftList as $category)
            @foreach($category->abilities as $ability)
                <tr>
                    @if($loop->first)
                        <td rowspan="{{ $loop->count }}">{{ $category->name }}</td>
                    @endif
                    <td>{{ $ability->name }}</td>
                    @if($ability->type == 'select')
                        <td>
                            <select name="{{ 'abilities['.$ability->id.'][score]' }}" id="">
                                <option value="0">선택</option>
                                <option value="1">경험없음</option>
                                <option value="2">미흡</option>
                                <option value="3">보통</option>
                                <option value="4">잘함</option>
                                <option value="5">매우잘함</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="{{ 'abilities['.$ability->id.'][can_learn]' }}" value="0">
                            <input type="checkbox" name="{{ 'abilities['.$ability->id.'][can_learn]' }}"
                                   value="1">
                        </td>
                    @else
                        <td colspan="2">
                            <input type="text" name="{{ 'abilities['.$ability->id.'][content]' }}">
                        </td>
                    @endif
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
    <table style="float:left;">
        <thead>
        <tr>
            <th colspan="2">구분</th>
            <th>점수</th>
            <th>가능</th>
        </tr>
        </thead>

        <tbody>
        @foreach($rightList as $category)
            @foreach($category->abilities as $ability)
                <tr>
                    @if($loop->first)
                        <td rowspan="{{ $loop->count }}">{{ $category->name }}</td>
                    @endif
                    <td>{{ $ability->name }}</td>
                    @if($ability->type == 'select')
                        <td>
                            <select name="{{ 'abilities['.$ability->id.'][score]' }}" id="">
                                <option value="0">선택</option>
                                <option value="1">경험없음</option>
                                <option value="2">미흡</option>
                                <option value="3">보통</option>
                                <option value="4">잘함</option>
                                <option value="5">매우잘함</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="{{ 'abilities['.$ability->id.'][can_learn]' }}" value="0">
                            <input type="checkbox" name="{{ 'abilities['.$ability->id.'][can_learn]' }}"
                                   value="1">
                        </td>
                    @else
                        <td colspan="2">
                            <input type="text" name="{{ 'abilities['.$ability->id.'][content]' }}">
                        </td>
                    @endif
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
    <button style="width: 200px; height: 120px;">
        등록
    </button>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</form>
</body>

</html>
