@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Parametros
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
                        {{ csrf_field() }}


                        <input type="hidden" name="readonlyname" id="readonlyname" value="0">
                        <div class="form-group{{ $errors->has('readonlyname') ? ' has-error' : '' }}">
                            <div class="col-md-offset-4  checkbox">
                                <div class="col-md-4">
                                    <label>
                                        <input id="readonlyname"
                                               type="checkbox"
                                               name="readonlyname"
                                               @if (isset($parameters->readonlyname))

                                               {{ $parameters->readonlyname == 1 ? 'checked' : ''}}
                                               @endif
                                               value="1"> Bloqueia nome
                                    </label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="readonlydescription" id="readonlydescription" value="0">
                        <div class="form-group{{ $errors->has('readonlydescription') ? ' has-error' : '' }}">
                            <div class="col-md-offset-4  checkbox">
                                <div class="col-md-4">
                                    <label>
                                        <input id="readonlydescription"
                                               type="checkbox"
                                               name="readonlydescription"
                                               @if (isset($parameters->readonlydescription))

                                               {{ $parameters->readonlydescription == 1 ? 'checked' : ''}}
                                               @endif
                                               value="1"> Bloqueia descrição
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

