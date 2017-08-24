@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Nova Categoria
                    <a class="pull-right" href="{{ url('admin/categories') }}">Voltar</a>
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
                                <input id="name" autofocus type="text" class="form-control" name="name" value="{{ isset($category->name) ? $category->name : old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
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
                                               @if (isset($category->isactive))
                                                                                                        
                                                {{ $category->isactive == 1 ? 'checked' : ''}}
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

