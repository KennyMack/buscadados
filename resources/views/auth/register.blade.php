@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal"
                  role="form"
                  method="POST"
                  novalidate
                  enctype="multipart/form-data"
                  action="{{ url('/register') }}">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 0; border-bottom: none;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#">Usuário</a></li>
                            <li><a href="#">Empresa</a></li>
                            <li><a href="#">Endereço</a></li>
                            <li><a href="#">Ramo de Atividade</a></li>
                        </ul>
                    </div>
                    <div class="panel-body" >
                        @if(Session::has('register'))
                            <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('register') }}
                            </div>
                        @endif

                        {{ csrf_field() }}
                        <div class="form-group">
                            &nbsp;
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-2">&nbsp;</div>
                            <div class="col-md-8">
                                <div class="group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input id="name" name="name" class="md" autofocus type="text" required value="{{ old('name') }}">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="name" class="md">Nome</label>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <div class="col-md-2">&nbsp;</div>
                            <div class="col-md-8">
                                <div class="group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                    <input id="lastname" name="lastname" class="md" type="text" required value="{{ old('lastname') }}">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="lastname" class="md">Sobrenome</label>
                                    @if ($errors->has('lastname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-2">&nbsp;</div>
                            <div class="col-md-8">
                                <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" name="email" class="md" type="text" required value="{{ old('email') }}">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="email" class="md">E-mail</label>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-2">&nbsp;</div>
                            <div class="col-md-8">
                                <div class="group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" name="password" class="md" type="password" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="password" class="md">Senha</label>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="col-md-2">&nbsp;</div>
                            <div class="col-md-8">
                                <div class="group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <input id="password_confirmation" name="password_confirmation" class="md" type="password" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="password_confirmation" class="md">Confirmar senha</label>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>




                        <!--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

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
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">

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
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

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
                        </div>-->

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Registrar
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">


$(document).ready( function() {
    var cbeState = $('#state_id');
    var cbeCity = $('#city_id');


    function loadCities() {
        var state_id = cbeState.val();
        var country_id = 1;//$('#country_id').val();
        if (state_id > -1) {
            $.get('{{ url('/') }}'+'/api/country/' + country_id + '/state/' + state_id + '/cities', function (data) {
                try {
                    var citiesJson = data;
                    var cbeCity = $('#city_id');
                    cbeCity.empty();
                    cbeCity.append(new Option('[--Selecione--]', '-1'));
                    for (var i = 0, items = citiesJson.length; i < items; i++) {
                        cbeCity.append(new Option(citiesJson[i].name, citiesJson[i].id));

                    }

                    setCity();
                }
                catch (e) {
                    console.log(e);
                }

            });

        }
        else
            clearCities();

    }

    function clearCities() {
        cbeCity.empty();
        cbeCity.append(new Option('[--Selecione--]', '-1'));
    }

    function setCity() {

        var id_city = '{{ old('city_id') }}';

        if (id_city) {

            cbeCity.val(id_city).change();
        }
    }


    cbeState.change(function() {
        loadCities();
    });

    loadCities();

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
                $('#imgdata').val(e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function(){
        readURL(this);
    });
});


</script>

<style type="text/css">
    .thumbnail {
        box-sizing: border-box;
        margin: 0 auto;
    }

    .img-container {
        box-sizing: border-box;
        padding: 10px 0 10px 0;
    }

    .panel-middle-heading {
        border-radius: 0;
        border-top: 1px solid #ddd;
    }

    .btn-image {
        cursor: pointer;
        margin: 0 auto;
        background-color: orange;
        display: inline;
    }
    .inputfile {
        display: none!important;
    }

    /*.inputfile {
        margin: 0 auto;
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        padding: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }*/
    /*.btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    #img-upload{
        width: 100%;
    }*/
</style>
@endsection
