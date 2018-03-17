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
                      @if(Request::is('*/profile/*'))
                      action="{{ url('companies/profile/address/save') }}"
                      @else
                      action="{{ url('register/address/save') }}"
                      @endif>
                    <div class="modal" id="modal-form">
                        <div class="windows8">
                            <div class="wBall" id="wBall_1">
                                <div class="wInnerBall"></div>
                            </div>
                            <div class="wBall" id="wBall_2">
                                <div class="wInnerBall"></div>
                            </div>
                            <div class="wBall" id="wBall_3">
                                <div class="wInnerBall"></div>
                            </div>
                            <div class="wBall" id="wBall_4">
                                <div class="wInnerBall"></div>
                            </div>
                            <div class="wBall" id="wBall_5">
                                <div class="wInnerBall"></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 0; border-bottom: none;">
                            <ul class="nav nav-tabs">
                                @if($tabuser)
                                    <li><a href="#">Usuário</a></li>
                                @endif
                                <li><a href="{{ $urlcompany }}">Empresa</a></li>
                                <li class="active"><a href="{{ $urladdress }}">Endereço</a></li>
                                <li><a href="{{ $urlcategory }}">Ramo de Atividade</a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            @if(Session::has('register'))
                                <div class="alert alert-warning alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('register') }}
                                </div>
                            @endif
                            {{ csrf_field() }}
                            <div class="form-group">
                                &nbsp;
                            </div>

                            <div class="form-group{{ $errors->has('postalnumber') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('postalnumber') ? ' has-error' : '' }}">
                                        <input id="postalnumber" name="postalnumber" class="md" type="text" required
                                               maxlength="9" autofocus autocomplete="postalnumber"
                                               value="{{ isset($company->postalnumber) ? $company->postalnumber : old('postalnumber') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="postalnumber" class="md">CEP *</label>
                                        @if ($errors->has('postalnumber'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('postalnumber') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <input id="address" name="address" class="md" type="text" required
                                               autocomplete="address"
                                               value="{{ isset($company->address) ? $company->address : old('address') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="address" class="md">Endereço *</label>
                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('number') ? ' has-error' : '' }}">
                                        <input id="number" name="number" class="md" type="text" required
                                               autocomplete="number"
                                               value="{{ isset($company->number) ? $company->number : old('number') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="number" class="md">Numero *</label>
                                        @if ($errors->has('number'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('number') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('district') ? ' has-error' : '' }}">
                                        <input id="district" name="district" class="md" type="text" required
                                               autocomplete="district"
                                               value="{{ isset($company->district) ? $company->district : old('district') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="district" class="md">Bairro *</label>
                                        @if ($errors->has('district'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('district') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('state_id') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('state_id') ? ' has-error' : '' }}">
                                        <select class="md"
                                                id="state_id"
                                                title="Estado"
                                                autocomplete="state_id"
                                                name="state_id">
                                            <option value="-1">Estado *</option>
                                            @foreach ($states as $optstate)
                                                <option
                                                        data-initials="{{ $optstate->initials }}"
                                                        value="{{ $optstate->id }}"
                                                        @if(old('state_id') == $optstate->id)
                                                        selected="true"
                                                        @elseif((isset($company->city) ? $company->city->state->id : '') == $optstate->id)
                                                        selected="true"
                                                        @endif
                                                >{{ ucwords($optstate->name) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <!--<label for="state_id" class="md">Estado</label>-->
                                        @if ($errors->has('state_id'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('state_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                        <select class="md"
                                                id="city_id"
                                                autocomplete="city_id"
                                                title="Cidade"
                                                name="city_id">
                                            <option value="-1">Cidade *</option>
                                            @foreach ($cities as $optcity)
                                                <option
                                                        @if(old('city_id') == $optcity->id)
                                                        selected="true"
                                                        @elseif($company->city_id == $optcity->id)
                                                        selected="true"
                                                        @endif
                                                >{{ ucwords($optcity->name) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <!--<label for="state_id" class="md">Estado</label>-->
                                        @if ($errors->has('city_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('city_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <input id="phone" name="phone" class="md" type="text" required
                                               maxlength="15" autocomplete="phone"
                                               value="{{ isset($company->phone) ? $company->phone : old('phone') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="phone" class="md">Telefone</label>
                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('cellphone') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('cellphone') ? ' has-error' : '' }}">
                                        <input id="cellphone" name="cellphone" class="md" type="text" required
                                               maxlength="15" autocomplete="cellphone"
                                               value="{{ isset($company->cellphone) ? $company->cellphone : old('cellphone') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="cellphone" class="md">Celular</label>
                                        @if ($errors->has('cellphone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cellphone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('site') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('site') ? ' has-error' : '' }}">
                                        <input id="site" name="site" class="md" type="text" required
                                               maxlength="60" autocomplete="site"
                                               value="{{ isset($company->site) ? $company->site : old('site') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="site" class="md">Site</label>
                                        @if ($errors->has('site'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('site') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    @if(Request::is('*/profile/*'))
                                        <button type="submit" class="btn btn-primary">
                                            <i class="glyphicon glyphicon-floppy-disk"></i> Salvar alterações
                                        </button>
                                    @else
                                        <a href="{{ url('/register/company')  }}" class="btn btn-default">
                                            <i style="font-size: 1.1rem" class="fa fa-btn fa-chevron-left"></i> Voltar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            Avançar <i style="font-size: 1.1rem" class="fa fa-btn fa-chevron-right"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <p class="help-block">* Campos obrigatórios</p>
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
            var id_city = '{{ isset($company->city_id) ? $company->city_id : old('city_id') }}';

            cbeState.change(function() {
                window.demograph.loadCities(cbeCity, 1, cbeState.val(), id_city);
            });

            window.demograph.loadCities(cbeCity, 1, cbeState.val(), id_city);

            /*var cbeState = $('#state_id');
            var cbeCity = $('#city_id');

            function loadCities() {
                var state_id = cbeState.val();
                var country_id = 1;//$('#country_id').val();
                if (state_id > -1) {
                    window.request._get('/api/country/' + country_id + '/state/' + state_id + '/cities', function(data) {
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

                var id_city = '{ isset($company->city_id) ? $company->city_id : old('city_id') }}';

                if (id_city) {

                    cbeCity.val(id_city).change();
                }
            }


            cbeState.change(function() {
                loadCities();
            });

            loadCities();*/
        });


    </script>

    <style type="text/css">

        .panel-middle-heading {
            border-radius: 0;
            border-top: 1px solid #ddd;
        }

        .modal {
            display: none;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,.5);
        }

        .windows8 {
            position: absolute;
            left:50%;
            top:50%;
            width: 66px;
            height: 66px;
            margin-top: -33px;
            margin-left: -33px;
        }

        .windows8 .wBall {
            position: absolute;
            width: 63px;
            height: 63px;
            opacity: 0;
            transform: rotate(225deg);
            -o-transform: rotate(225deg);
            -ms-transform: rotate(225deg);
            -webkit-transform: rotate(225deg);
            -moz-transform: rotate(225deg);
            animation: orbit 5.7425s infinite;
            -o-animation: orbit 5.7425s infinite;
            -ms-animation: orbit 5.7425s infinite;
            -webkit-animation: orbit 5.7425s infinite;
            -moz-animation: orbit 5.7425s infinite;
        }

        .windows8 .wBall .wInnerBall{
            position: absolute;
            width: 8px;
            height: 8px;
            background: rgba(58,58,58,0.96);
            left:0px;
            top:0px;
            border-radius: 8px;
        }

        .windows8 #wBall_1 {
            animation-delay: 1.256s;
            -o-animation-delay: 1.256s;
            -ms-animation-delay: 1.256s;
            -webkit-animation-delay: 1.256s;
            -moz-animation-delay: 1.256s;
        }

        .windows8 #wBall_2 {
            animation-delay: 0.243s;
            -o-animation-delay: 0.243s;
            -ms-animation-delay: 0.243s;
            -webkit-animation-delay: 0.243s;
            -moz-animation-delay: 0.243s;
        }

        .windows8 #wBall_3 {
            animation-delay: 0.5065s;
            -o-animation-delay: 0.5065s;
            -ms-animation-delay: 0.5065s;
            -webkit-animation-delay: 0.5065s;
            -moz-animation-delay: 0.5065s;
        }

        .windows8 #wBall_4 {
            animation-delay: 0.7495s;
            -o-animation-delay: 0.7495s;
            -ms-animation-delay: 0.7495s;
            -webkit-animation-delay: 0.7495s;
            -moz-animation-delay: 0.7495s;
        }

        .windows8 #wBall_5 {
            animation-delay: 1.003s;
            -o-animation-delay: 1.003s;
            -ms-animation-delay: 1.003s;
            -webkit-animation-delay: 1.003s;
            -moz-animation-delay: 1.003s;
        }



        @keyframes orbit {
            0% {
                opacity: 1;
                z-index:99;
                transform: rotate(180deg);
                animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                transform: rotate(300deg);
                animation-timing-function: linear;
                origin:0%;
            }

            30% {
                opacity: 1;
                transform:rotate(410deg);
                animation-timing-function: ease-in-out;
                origin:7%;
            }

            39% {
                opacity: 1;
                transform: rotate(645deg);
                animation-timing-function: linear;
                origin:30%;
            }

            70% {
                opacity: 1;
                transform: rotate(770deg);
                animation-timing-function: ease-out;
                origin:39%;
            }

            75% {
                opacity: 1;
                transform: rotate(900deg);
                animation-timing-function: ease-out;
                origin:70%;
            }

            76% {
                opacity: 0;
                transform:rotate(900deg);
            }

            100% {
                opacity: 0;
                transform: rotate(900deg);
            }
        }

        @-o-keyframes orbit {
            0% {
                opacity: 1;
                z-index:99;
                -o-transform: rotate(180deg);
                -o-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -o-transform: rotate(300deg);
                -o-animation-timing-function: linear;
                -o-origin:0%;
            }

            30% {
                opacity: 1;
                -o-transform:rotate(410deg);
                -o-animation-timing-function: ease-in-out;
                -o-origin:7%;
            }

            39% {
                opacity: 1;
                -o-transform: rotate(645deg);
                -o-animation-timing-function: linear;
                -o-origin:30%;
            }

            70% {
                opacity: 1;
                -o-transform: rotate(770deg);
                -o-animation-timing-function: ease-out;
                -o-origin:39%;
            }

            75% {
                opacity: 1;
                -o-transform: rotate(900deg);
                -o-animation-timing-function: ease-out;
                -o-origin:70%;
            }

            76% {
                opacity: 0;
                -o-transform:rotate(900deg);
            }

            100% {
                opacity: 0;
                -o-transform: rotate(900deg);
            }
        }

        @-ms-keyframes orbit {
            0% {
                opacity: 1;
                z-index:99;
                -ms-transform: rotate(180deg);
                -ms-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -ms-transform: rotate(300deg);
                -ms-animation-timing-function: linear;
                -ms-origin:0%;
            }

            30% {
                opacity: 1;
                -ms-transform:rotate(410deg);
                -ms-animation-timing-function: ease-in-out;
                -ms-origin:7%;
            }

            39% {
                opacity: 1;
                -ms-transform: rotate(645deg);
                -ms-animation-timing-function: linear;
                -ms-origin:30%;
            }

            70% {
                opacity: 1;
                -ms-transform: rotate(770deg);
                -ms-animation-timing-function: ease-out;
                -ms-origin:39%;
            }

            75% {
                opacity: 1;
                -ms-transform: rotate(900deg);
                -ms-animation-timing-function: ease-out;
                -ms-origin:70%;
            }

            76% {
                opacity: 0;
                -ms-transform:rotate(900deg);
            }

            100% {
                opacity: 0;
                -ms-transform: rotate(900deg);
            }
        }

        @-webkit-keyframes orbit {
            0% {
                opacity: 1;
                z-index:99;
                -webkit-transform: rotate(180deg);
                -webkit-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -webkit-transform: rotate(300deg);
                -webkit-animation-timing-function: linear;
                -webkit-origin:0%;
            }

            30% {
                opacity: 1;
                -webkit-transform:rotate(410deg);
                -webkit-animation-timing-function: ease-in-out;
                -webkit-origin:7%;
            }

            39% {
                opacity: 1;
                -webkit-transform: rotate(645deg);
                -webkit-animation-timing-function: linear;
                -webkit-origin:30%;
            }

            70% {
                opacity: 1;
                -webkit-transform: rotate(770deg);
                -webkit-animation-timing-function: ease-out;
                -webkit-origin:39%;
            }

            75% {
                opacity: 1;
                -webkit-transform: rotate(900deg);
                -webkit-animation-timing-function: ease-out;
                -webkit-origin:70%;
            }

            76% {
                opacity: 0;
                -webkit-transform:rotate(900deg);
            }

            100% {
                opacity: 0;
                -webkit-transform: rotate(900deg);
            }
        }

        @-moz-keyframes orbit {
            0% {
                opacity: 1;
                z-index:99;
                -moz-transform: rotate(180deg);
                -moz-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -moz-transform: rotate(300deg);
                -moz-animation-timing-function: linear;
                -moz-origin:0%;
            }

            30% {
                opacity: 1;
                -moz-transform:rotate(410deg);
                -moz-animation-timing-function: ease-in-out;
                -moz-origin:7%;
            }

            39% {
                opacity: 1;
                -moz-transform: rotate(645deg);
                -moz-animation-timing-function: linear;
                -moz-origin:30%;
            }

            70% {
                opacity: 1;
                -moz-transform: rotate(770deg);
                -moz-animation-timing-function: ease-out;
                -moz-origin:39%;
            }

            75% {
                opacity: 1;
                -moz-transform: rotate(900deg);
                -moz-animation-timing-function: ease-out;
                -moz-origin:70%;
            }

            76% {
                opacity: 0;
                -moz-transform:rotate(900deg);
            }

            100% {
                opacity: 0;
                -moz-transform: rotate(900deg);
            }
        }
    </style>
@endsection

@section('import')
    <script src="{{ asset('js/core/request.core.js') }}"></script>
    <script src="{{ asset('js/forms/demograph/demograph.js') }}"></script>
    <script src="{{ asset('js/forms/validation/validate.js') }}"></script>
    <script src="{{ asset('js/forms/validation/format.js') }}"></script>
    <script src="{{ asset('js/forms/company/address.form.js') }}"></script>
@endsection