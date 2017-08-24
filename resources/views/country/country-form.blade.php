@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo País
                    <a class="pull-right" href="{{ url('admin/countries') }}">Voltar</a>
                </div>
                <div class="panel-body">

                    @if(Session::has('message_success'))
                        <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ Session::get('message_success') }}
                        </div>
                    @endif
                    <form class="form-horizontal" 
                          role="form"
                          method="POST"
                          action="{{ url($url) }}">
                        @if(Request::is('*/change'))
                            <input name="_method" type="hidden" value="PUT" />
                        @endif
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('initials') ? ' has-error' : '' }}">
                            <label for="initials" class="col-md-4 control-label">Sigla</label>

                            <div class="col-md-6">
                                <input id="initials" 
                                    autofocus 
                                    type="text" 
                                    class="form-control" 
                                    name="initials" 
                                    value="{{ isset($country->initials) ? $country->initials : old('initials') }}">

                                @if ($errors->has('initials'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('initials') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" 
                                    autofocus 
                                    type="text"
                                    class="form-control" 
                                    name="name" 
                                    value="{{ isset($country->name) ? $country->name : old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

