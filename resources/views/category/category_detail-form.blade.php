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
                        @if(Session::has('message_danger'))
                            <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message_danger') }}
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
                                    <input id="name" autofocus type="text" class="form-control" name="name" value="{{ isset($categoryDetail->name) ? $categoryDetail->name : old('name') }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('minvalue') ? ' has-error' : '' }}">
                                <label for="minvalue" class="col-md-4 control-label">Valor minimo</label>

                                <div class="col-md-6">
                                    <input id="minvalue" autofocus type="text" class="form-control" name="minvalue" value="{{ isset($categoryDetail->minvalue) ? $categoryDetail->minvalue : old('minvalue') }}">

                                    @if ($errors->has('minvalue'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('minvalue') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('maxvalue') ? ' has-error' : '' }}">
                                <label for="maxvalue" class="col-md-4 control-label">Valor máximo</label>

                                <div class="col-md-6">
                                    <input id="maxvalue" autofocus type="text" class="form-control" name="maxvalue" value="{{ isset($categoryDetail->maxvalue) ? $categoryDetail->maxvalue : old('maxvalue') }}">

                                    @if ($errors->has('maxvalue'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('maxvalue') }}</strong>
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
                                                   @if (isset($categoryDetail->isactive))

                                                   {{ $categoryDetail->isactive == 1 ? 'checked' : ''}}
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
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="2"
                                        width="5%">&nbsp;</th>
                                    <th>Descrição</th>
                                    <th>Valor Minimo</th>
                                    <th>Valor Máximo</th>
                                    <th>Ativo</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($categorydetails as $category)
                                    <tr>
                                        <td><a class="btn btn-default btn-xs" href="{{ url('admin/categories/'.$idCategory.'/detail/'.$category->id.'/change' ) }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                        <td>
                                            <form style="display: inline;"
                                                  method="POST"
                                                  action="{{ url('admin/categories/'.$idCategory.'/detail/'.$category->id.'/remove' ) }}">
                                                <input name="_method" type="hidden" value="DELETE">
                                                {{ csrf_field() }}
                                                <button class="btn btn-danger btn-xs"
                                                        type="submit"
                                                        name="remove_levels"><span class="glyphicon glyphicon-trash"></span></button>
                                            </form>

                                        </td>
                                        <td>{{ ucwords($category->name) }}</td>
                                        <td>{{ $category->minvalue }}</td>
                                        <td>{{ $category->maxvalue }}</td>
                                        <td>
                                            <input type="checkbox"
                                                   name="isactive"
                                                   disabled="true"
                                                   {{ $category->isactive == 1 ? 'checked' :'' }}
                                                   value="{{ $category->isactive }}">
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="confirmModal" style="display: none; z-index: 1050;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="confirmMessage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="confirmOk">Ok</button>
                    <button type="button" class="btn btn-default" id="confirmCancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function confirmDialog(message, onConfirm){
            var fClose = function(){
                modal.modal("hide");
            };
            var modal = $("#confirmModal");
            modal.modal("show");
            $("#confirmMessage").empty().append(message);
            $("#confirmOk").one('click', onConfirm);
            $("#confirmOk").one('click', fClose);
            $("#confirmCancel").one("click", fClose);
        }


        $('button[name="remove_levels"]').on('click', function(e) {
            $form = $(this).closest('form');
            e.preventDefault();
            confirmDialog('Confirma a exclusão ?', function() {
                $form.trigger('submit');
            });
        });
    </script>
@endsection

