<form action="{{ route('resetPassword',['token'=>$token]) }}" method="post">
    @csrf
    <input type="hidden" name="token" id="token" value="{{$token}}">
    <input type="password" id="password" name="password">
    <input type="password" id="password_confirm" name="password_confirm">
    <input type="submit">
</form>