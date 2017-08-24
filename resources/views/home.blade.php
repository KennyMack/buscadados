@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(Session::has('message_success'))
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message_success') }}
                        </div>
                    @endif

                    <p>Seja bem vindo ao CNSF</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
