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

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ordenação</label>

                            <div class="col-md-6">
                                <input id="orderby" type="number" class="form-control" name="orderby"
                                       required
                                       value="{{ isset($category->orderby) ? $category->orderby : old('orderby') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('orderby') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label">Tipo Categoria</label>
                            <div class="col-md-6">
                                <select class="form-control"
                                        id="type"
                                        name="type">
                                    <option>[--Selecione--]</option>
                                    <option
                                            @if(isset($category->type))
                                            {{ $category->type == 0 ?
                                               'selected="true"' : ' ' }}
                                            @else
                                            {{ old('type') == 0 ?
                                               'selected="true"' : ' ' }}
                                            @endif
                                            value="0">Categoria detalhada</option>
                                    <option
                                            @if(isset($category->type))
                                            {{ $category->type == 1 ?
                                               'selected="true"' : ' ' }}
                                            @else
                                            {{ old('type') == 1 ?
                                               'selected="true"' : ' ' }}
                                            @endif
                                            value="1">Contrato</option>
                                </select>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="icon" id="icon" value="{{ $category->icon }}">
                        <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label">&nbsp;</label>
                            <div class="col-md-6">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Icone Categoria
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="cursor:pointer;">
                                        <li  style="cursor:pointer;" id="li-ropt1">

                                            <label style="padding-top:5px; padding-left: 20px; padding-right: 20px;">
                                                <input id="ropt1"
                                                       type="radio"
                                                       name="ropt1"
                                                       @if (isset($category->icon))
                                                            {{ $category->icon == 1 ? 'checked' : ''}}
                                                       @endif
                                                       value="1"> <img style="margin-left: -25px; width: 32px; height: 32px;" src="{{ asset('/assets/img/1.jpg')  }}" /> Empresa Funerária
                                            </label>
                                        </li>
                                        <li  style="cursor:pointer;" id="li-ropt2">

                                            <label style="padding-top:5px;padding-left: 20px; padding-right: 20px;">
                                                <input id="ropt2"
                                                       type="radio"
                                                       name="ropt2"
                                                       @if (isset($category->icon))
                                                       {{ $category->icon == 2 ? 'checked' : ''}}
                                                       @endif
                                                       value="2"> <img style="margin-left: -25px; width: 32px; height: 32px;" src="{{ asset('/assets/img/2.jpg')  }}" /> Emp. Admin. de Planos de Assist. Funeral
                                            </label>
                                        </li>
                                        <li  style="cursor:pointer;" id="li-ropt3">

                                            <label style="padding-top:5px;padding-left: 20px; padding-right: 20px;">
                                                <input id="ropt3"
                                                       type="radio"
                                                       name="ropt3"
                                                       @if (isset($category->icon))
                                                       {{ $category->icon == 3 ? 'checked' : ''}}
                                                       @endif
                                                       value="3"> <img style="margin-left: -25px; width: 32px; height: 32px;" src="{{ asset('/assets/img/3.jpg')  }}" /> Laboratório de Tanatopraxia
                                            </label>
                                        </li>
                                        <li  style="cursor:pointer;" id="li-ropt4">

                                            <label style="padding-top:5px;padding-left: 20px; padding-right: 20px;">
                                                <input id="ropt4"
                                                       type="radio"
                                                       name="ropt4"
                                                       @if (isset($category->icon))
                                                       {{ $category->icon == 4 ? 'checked' : ''}}
                                                       @endif
                                                       value="4"> <img style="margin-left: -25px; width: 32px; height: 32px;" src="{{ asset('/assets/img/4.jpg')  }}" /> Crematório
                                            </label>
                                        </li>
                                        <li  style="cursor:pointer;" id="li-ropt5">

                                            <label style="padding-top:5px;padding-left: 20px; padding-right: 20px;">
                                                <input id="ropt5"
                                                       type="radio"
                                                       name="ropt5"
                                                       @if (isset($category->icon))
                                                       {{ $category->icon == 5 ? 'checked' : ''}}
                                                       @endif
                                                       value="5"> <img style="margin-left: -25px; width: 32px; height: 32px;" src="{{ asset('/assets/img/5.jpg')  }}" /> Empresa de Artefatos Fúnebres
                                            </label>
                                        </li>
                                        <li  style="cursor:pointer;" id="li-ropt6">

                                            <label style="padding-top:5px;padding-left: 20px; padding-right: 20px;">
                                                <input id="ropt6"
                                                       type="radio"
                                                       name="ropt6"
                                                       @if (isset($category->icon))
                                                       {{ $category->icon == 6 ? 'checked' : ''}}
                                                       @endif
                                                       value="6"> <img style="margin-left: -25px; width: 32px; height: 32px;" src="{{ asset('/assets/img/6.jpg')  }}" /> Industria de Urnas Mortuárias
                                            </label>
                                        </li>
                                        <li  style="cursor:pointer;" id="li-ropt7">

                                            <label style="padding-top:5px;padding-left: 20px; padding-right: 20px;">
                                                <input id="ropt7"
                                                       type="radio"
                                                       name="ropt7"
                                                       @if (isset($category->icon))
                                                       {{ $category->icon == 7 ? 'checked' : ''}}
                                                       @endif
                                                       value="7"> <img style="margin-left: -25px; width: 32px; height: 32px;" src="{{ asset('/assets/img/7.jpg')  }}" /> Empresa de Equipamentos Funerários
                                            </label>
                                        </li>
                                        <li  style="cursor:pointer;" id="li-ropt8">

                                            <label style="padding-top:5px;padding-left: 20px; padding-right: 20px;">
                                                <input id="ropt8"
                                                       type="radio"
                                                       name="ropt8"
                                                       @if (isset($category->icon))
                                                       {{ $category->icon == 8 ? 'checked' : ''}}
                                                       @endif
                                                       value="8"> <img style="margin-left: -25px; width: 32px; height: 32px;" src="{{ asset('/assets/img/8.jpg')  }}" /> Empresa de Carros Transformação de Veículos Fúnebres
                                            </label>
                                        </li>
                                        <li  style="cursor:pointer;" id="li-ropt9">

                                            <label style="padding-top:5px;padding-left: 20px; padding-right: 20px;">
                                                <input id="ropt9"
                                                       type="radio"
                                                       name="ropt9"
                                                       @if (isset($category->icon))
                                                       {{ $category->icon == 9 ? 'checked' : ''}}
                                                       @endif
                                                       value="9"> <img style="margin-left: -25px; width: 32px; height: 32px;" src="{{ asset('/assets/img/9.jpg')  }}" /> Empresas de Produtos e Equipamentos de Tanatopraxia
                                            </label>
                                        </li>
                                    </ul>
                                </div>

                                @if ($errors->has('icon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('icon') }}</strong>
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
<style type="text/css">
    input[type=radio] {
        font-size: 1px!important;
    }
</style>
    <script>
        (function (window) {
            $(document).ready( function() {
                var icon = $('#icon');
                var ropt1 = $('#ropt1');
                var ropt2 = $('#ropt2');
                var ropt3 = $('#ropt3');
                var ropt4 = $('#ropt4');
                var ropt5 = $('#ropt5');
                var ropt6 = $('#ropt6');
                var ropt7 = $('#ropt7');
                var ropt8 = $('#ropt8');
                var ropt9 = $('#ropt9');



                function clearColor(){
                    $('#li-ropt1').css({ 'background': '#fff' });
                    $('#li-ropt2').css({ 'background': '#fff' });
                    $('#li-ropt3').css({ 'background': '#fff' });
                    $('#li-ropt4').css({ 'background': '#fff' });
                    $('#li-ropt5').css({ 'background': '#fff' });
                    $('#li-ropt6').css({ 'background': '#fff' });
                    $('#li-ropt7').css({ 'background': '#fff' });
                    $('#li-ropt8').css({ 'background': '#fff' });
                    $('#li-ropt9').css({ 'background': '#fff' });
                }

                function loadPage() {
                    clearColor();
                    var i = icon.val();
                    $('#li-ropt' + i).css({ 'background': '#c7c7c7' });
                    icon.val(i);
                }
                loadPage();



                ropt1.change(function(){
                    clearColor();
                    $('#li-ropt1').css({ 'background': '#c7c7c7' });
                    icon.val('1');
                });
                ropt2.change(function(){
                    clearColor();
                    $('#li-ropt2').css({ 'background': '#c7c7c7' });
                    icon.val('2');
                });
                ropt3.change(function(){
                    clearColor();
                    $('#li-ropt3').css({ 'background': '#c7c7c7' });
                    icon.val('3');
                });
                ropt4.change(function(){
                    clearColor();
                    $('#li-ropt4').css({ 'background': '#c7c7c7' });
                    icon.val('4');
                });
                ropt5.change(function(){
                    clearColor();
                    $('#li-ropt5').css({ 'background': '#c7c7c7' });
                    icon.val('5');
                });
                ropt6.change(function(){
                    clearColor();
                    $('#li-ropt6').css({ 'background': '#c7c7c7' });
                    icon.val('6');
                });
                ropt7.change(function(){
                    clearColor();
                    $('#li-ropt7').css({ 'background': '#c7c7c7' });
                    icon.val('7');
                });
                ropt8.change(function(){
                    clearColor();
                    $('#li-ropt8').css({ 'background': '#c7c7c7' });
                    icon.val('8');
                });
                ropt9.change(function(){
                    clearColor();
                    $('#li-ropt9').css({ 'background': '#c7c7c7' });
                    icon.val('9');
                });
            });

        }(window));
    </script>

@endsection


