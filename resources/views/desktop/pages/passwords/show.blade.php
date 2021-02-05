<form action="{{ route('resetPassword',['token'=>$token]) }}" method="post">
    @csrf
    <input type="password" id="password" name="password">
    <input type="submit">
</form>