@extends('layouts.Default')
@section('content')
@include('includes.DashboardMessages')
<form class="form-signin" action="{{{ $_pageAction }}}" method="post">
    <h2 class="form-signin-heading">Please Sign In</h2>
    <div class="login-wrap">
        <input type="text" class="form-control" placeholder="Email Address" name="HJ)as9M*#" value="{{{ $email }}}" autofocus />
        <input type="password" class="form-control" placeholder="Password" name="lN9S*&n#">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
        <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
</form>
@stop
