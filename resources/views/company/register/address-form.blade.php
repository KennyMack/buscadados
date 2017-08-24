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
                      @endif

                >
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



                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <input id="address" name="address" class="md" type="text" required
                                               autofocus
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
                            <!--<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="col-md-4 control-label">Endereço</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control" name="address"
                                           autofocus
                                           value="{{ isset($company->address) ? $company->address : old('address') }}">

                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>-->

                            <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('number') ? ' has-error' : '' }}">
                                        <input id="number" name="number" class="md" type="text" required
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

                            <!--<div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
                                <label for="number" class="col-md-4 control-label">Numero</label>

                                <div class="col-md-6">
                                    <input id="number" type="text" class="form-control" name="number"
                                           value="{{ isset($company->number) ? $company->number : old('number') }}">

                                    @if ($errors->has('number'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('number') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>-->

                            <div class="form-group{{ $errors->has('postalnumber') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('postalnumber') ? ' has-error' : '' }}">
                                        <input id="postalnumber" name="postalnumber" class="md" type="text" required
                                               maxlength="9"
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

                            <!--<div class="form-group{{ $errors->has('postalnumber') ? ' has-error' : '' }}">
                                <label for="postalnumber" class="col-md-4 control-label">CEP</label>

                                <div class="col-md-6">
                                    <input id="postalnumber" type="text" class="form-control" name="postalnumber"
                                           maxlength="9"
                                           value="{{ isset($company->postalnumber) ? $company->postalnumber : old('postalnumber') }}">

                                    @if ($errors->has('postalnumber'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('postalnumber') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>-->

                            <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('district') ? ' has-error' : '' }}">
                                        <input id="district" name="district" class="md" type="text" required
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

                            <!--<div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                                <label for="district" class="col-md-4 control-label">Bairro</label>

                                <div class="col-md-6">
                                    <input id="district" type="text" class="form-control" name="district"
                                           value="{{ isset($company->district) ? $company->district : old('district') }}">

                                    @if ($errors->has('district'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('district') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>-->

                            <div class="form-group{{ $errors->has('state_id') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('state_id') ? ' has-error' : '' }}">
                                        <select class="md"
                                                id="state_id"
                                                title="Estado"
                                                name="state_id">
                                            <option value="-1">Estado *</option>
                                            @foreach ($states as $optstate)
                                                <option
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
                            <!--<div class="form-group{{ $errors->has('state_id') ? ' has-error' : '' }}">
                                <label for="state_id" class="col-md-4 control-label">Estado</label>
                                <div class="col-md-6">
                                    <select class="form-control"
                                            id="state_id"
                                            name="state_id">
                                        <option>[--Selecione--]</option>
                                        @foreach ($states as $optstate)
                                            <option
                                                    value="{{ $optstate->id }}"
                                                    @if(old('state_id') == $optstate->id)
                                                    selected="true"
                                                    @elseif((isset($company->city) ? $company->city->state->id : '') == $optstate->id)
                                                    selected="true"
                                                    @endif
                                            >{{ ucwords($optstate->name) }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('state_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('state_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>-->

                            <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                        <select class="md"
                                                id="city_id"
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
                            <!--<div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                <label for="city_id" class="col-md-4 control-label">Cidade</label>
                                <div class="col-md-6">
                                    <select class="form-control"
                                            id="city_id"
                                            name="city_id">
                                        <option>[--Selecione--]</option>
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
                                    @if ($errors->has('city_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('city_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>-->

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-8">
                                        <div class="group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                            <input id="phone" name="phone" class="md" type="text" required
                                                   maxlength="15"
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

                            <!--<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class="col-md-4 control-label">Telefone</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone"
                                           maxlength="15"
                                           value="{{ isset($company->phone) ? $company->phone : old('phone') }}">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>-->

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    @if(Request::is('*/profile/*'))
                                        <button type="submit" class="btn btn-primary">
                                            <i class="glyphicon glyphicon-floppy-disk"></i> Salvar alterações
                                        </button>
                                    @else
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
    </style>
@endsection

@section('import')
    <script src="{{ asset('js/core/request.core.js') }}"></script>
    <script src="{{ asset('js/forms/demograph/demograph.js') }}"></script>
    <script src="{{ asset('js/forms/validation/validate.js') }}"></script>
    <script src="{{ asset('js/forms/validation/format.js') }}"></script>
    <script src="{{ asset('js/forms/company/address.form.js') }}"></script>
@endsection