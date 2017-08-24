@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Estado
                    <a class="pull-right" href="{{ url('admin/states') }}">Voltar</a>
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
                                    value="{{ isset($state->initials) ? $state->initials : old('initials') }}">

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
                                    value="{{ isset($state->name) ? $state->name : old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label for="country_id" class="col-md-4 control-label">País</label>
                            <div class="col-md-6">
                                <select class="form-control" 
                                        id="country_id"
                                        name="country_id">
                                    <option>[--Selecione--]</option>
                                    @foreach ($countries as $optcountry)
                                    <option 
                                        value="{{ $optcountry->id }}"
                                        @if(isset($state->country_id))
                                            {{ $state->country_id == $optcountry->id ?
                                               'selected="true"' : ' ' }}
                                        @else
                                            {{ old('country_id') == $optcountry->id ?
                                               'selected="true"' : ' ' }}
                                        @endif
                                    >{{ $optcountry->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country_id') }}</strong>
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

