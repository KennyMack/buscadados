@extends('layouts.base-email')

@section('content')
    <p>
        Olá,<br/>
        Alteração de cadastro, aguardando verificação e liberação de acesso.
    </p>
    <dl>
        <dd><b>E-mail:</b> {{ $email }}</dd>
        <dd><b>Razão Social:</b> {{ $company->companyname }}</dd>
        <dd><b>Nome Fantasia:</b> {{ $company->tradingname}}</dd>
        <dd><b>CNPJ:</b>  {{ $company->cnpjcpf }}</dd>
    </dl>
    <a href="{{ url('admin/companies/'.$company->id.'/details') }}">Ver cadastro</a>
@endsection