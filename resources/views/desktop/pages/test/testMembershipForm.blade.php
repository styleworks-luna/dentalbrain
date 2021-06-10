<html>

<head>

    <title>123</title>
</head>
<body>
<h1>TestMembershipForm</h1>

@isset($expired_at)
    <h2>{{ $expired_at }}</h2>
@endisset

<form action="{{ route('test.JoinMembership') }}" method="post">
    @csrf
    <input type="hidden" name="days" value="30">
    <input type="submit" value="30일권">
</form>

<form action="{{ route('test.JoinMembership') }}" method="post">
    @csrf
    <input type="hidden" name="days" value="100 ">
    <input type="submit" value="100일권">
</form>
</body>
</html>



