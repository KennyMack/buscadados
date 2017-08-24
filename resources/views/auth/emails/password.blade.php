@extends('layouts.base-email')

@section('content')
    <p>Click aqui para redefinir sua senha: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>  </p>

@endsection