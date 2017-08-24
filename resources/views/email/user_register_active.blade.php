@extends('layouts.base-email')

@section('content')
    <p>
        Olá,<br/>
        @if($activated)
        Estamos felizes em informar que o seu cadastro foi ativado com sucesso.
        @else
        Gostariamos de informar que infelizmente seu cadastro nao foi ativado.
        @endif
    </p>
@endsection