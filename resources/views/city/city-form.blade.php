@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Nova cidade
                    <a class="pull-right" href="{{ url('admin/cities') }}">Voltar</a>
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

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" 
                                    autofocus 
                                    type="text"
                                    class="form-control" 
                                    name="name" 
                                    value="{{ isset($city->name) ? $city->name : old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('state_id') ? ' has-error' : '' }}">
                            <label for="state_id" class="col-md-4 control-label">Estado</label>
                            <div class="col-md-6">
                                <select class="form-control" 
                                        id="state_id"
                                        name="state_id">
                                    <option>[--Selecione--]</option>
                                    @foreach ($states as $optstate)
                                    <option 
                                        value="{{ $optstate->id }}"
                                        @if(isset($city->state_id))
                                            {{ $city->state_id == $optstate->id ?
                                               'selected="true"' : ' ' }}
                                        @else
                                            {{ old('state_id') == $optstate->id ?
                                               'selected="true"' : ' ' }}
                                        @endif
                                    >{{ $optstate->DescriptionInitials() }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('state_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state_id') }}</strong>
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

