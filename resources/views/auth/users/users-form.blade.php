@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Novo usuário
                        <a class="pull-right" href="{{ url('admin/users') }}">Voltar</a>
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
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ isset($user->name) ? $user->name : old('name') }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                <label for="lastname" class="col-md-4 control-label">Sobrenome</label>

                                <div class="col-md-6">
                                    <input id="lastname" type="text" class="form-control" name="lastname"
                                           value="{{ isset($user->lastname) ? $user->lastname : old('lastname') }}">

                                    @if ($errors->has('lastname'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           readonly
                                           value="{{ isset($user->email) ? $user->email : old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Senha</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirmar senha</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" name="isactive" id="isactive" value="0">
                            <div class="form-group{{ $errors->has('isactive') ? ' has-error' : '' }}">
                                <div class="col-md-offset-4  checkbox">
                                    <div class="col-md-4">
                                        <label>
                                            <input id="isactive"
                                                   type="checkbox"
                                                   name="isactive"
                                                   @if (isset($user->isactive))

                                                   {{ $user->isactive == 1 ? 'checked' : ''}}
                                                   @else
                                                   checked
                                                   @endif
                                                   value="1"> Ativo
                                        </label>
                                    </div>
                                </div>
                            </div>

                                <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Salvar
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

