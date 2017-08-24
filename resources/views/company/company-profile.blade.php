@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Meu cadastro
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-justified "  role="tablist">
                            <li role="presentation"
                                class="active">
                                <a href="#regional_search" aria-controls="regional_search" role="tab" data-toggle="tab">Dados Gerais</a>
                            </li>
                            <li role="presentation">
                                <a href="#name_search" aria-controls="name_search" role="tab" data-toggle="tab">Ramo de atividade</a>
                            </li>

                        </ul>


                        <form class="form-horizontal"
                              role="form"
                              method="POST"
                              action="{{ url( $url) }}">
                            <div class="tab-content clearfix" style="padding-top: 20px">
                                <div role="tabpanel"
                                     class="tab-pane active"
                                     id="regional_search">

                                    <div class="col-md-3 col-lg-3 " align="center">
                                        <img alt="Logotipo da empresa" src="{{ $company->getImage() }}"
                                             class="img-circle img-responsive">
                                    </div>
                                    <div class=" col-md-9 col-lg-9 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                            <tr>
                                                <td>Razão social:</td>
                                                <td>
                                                    <div class="form-group{{ $errors->has('companyname') ? ' has-error' : '' }}" style="margin: 0">
                                                        <input id="companyname"
                                                               title="Razão social"
                                                               autofocus
                                                               type="text"
                                                               class="form-control"
                                                               name="companyname"
                                                               value="{{ isset($company->companyname) ? $company->companyname : old('companyname') }}">

                                                        @if ($errors->has('companyname'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('companyname') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nome fantasia:</td>
                                                <td>
                                                    <div class="form-group{{ $errors->has('tradingname') ? ' has-error' : '' }}" style="margin: 0">
                                                        <input id="tradingname"
                                                               title="Nome fantasia"
                                                               autofocus
                                                               type="text"
                                                               class="form-control"
                                                               name="tradingname"
                                                               value="{{ isset($company->tradingname) ? $company->tradingname : old('tradingname') }}">

                                                        @if ($errors->has('tradingname'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('tradingname') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>CNPJ:</td>
                                                <td>
                                                    <div class="form-group{{ $errors->has('cnpjcpf') ? ' has-error' : '' }}" style="margin: 0">
                                                        <input id="cnpjcpf"
                                                               title="CNPJ"
                                                               autofocus
                                                               type="text"
                                                               class="form-control"
                                                               name="cnpjcpf"
                                                               value="{{ isset($company->cnpjcpf) ? $company->cnpjcpf : old('cnpjcpf') }}">

                                                        @if ($errors->has('cnpjcpf'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('cnpjcpf') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Endereço</b></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Rua:</td>
                                                <td>
                                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}" style="margin: 0">
                                                        <input id="address"
                                                               title="Rua"
                                                               autofocus
                                                               type="text"
                                                               class="form-control"
                                                               name="address"
                                                               value="{{ isset($company->address) ? $company->address : old('address') }}">

                                                        @if ($errors->has('address'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('address') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Número:</td>
                                                <td>
                                                    <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}" style="margin: 0">
                                                        <input id="number"
                                                               title="Número"
                                                               autofocus
                                                               type="text"
                                                               class="form-control"
                                                               name="number"
                                                               value="{{ isset($company->number) ? $company->number : old('number') }}">

                                                        @if ($errors->has('number'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('number') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bairro:</td>
                                                <td>
                                                    <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}" style="margin: 0">
                                                        <input id="district"
                                                               title="Bairro"
                                                               autofocus
                                                               type="text"
                                                               class="form-control"
                                                               name="district"
                                                               value="{{ isset($company->district) ? $company->district : old('district') }}">

                                                        @if ($errors->has('district'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('district') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>CEP:</td>
                                                <td>
                                                    <div class="form-group{{ $errors->has('postalnumber') ? ' has-error' : '' }}" style="margin: 0">
                                                        <input id="postalnumber"
                                                               title="CEP"
                                                               autofocus
                                                               type="text"
                                                               class="form-control"
                                                               name="postalnumber"
                                                               value="{{ isset($company->postalnumber) ? $company->postalnumber : old('postalnumber') }}">

                                                        @if ($errors->has('postalnumber'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('postalnumber') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Estado:</td>
                                                <td>
                                                    <div class="form-group{{ $errors->has('state_id') ? ' has-error' : '' }}" style="margin: 0">
                                                        <select class="form-control"
                                                                id="state_id"
                                                                title="Estado"
                                                                name="state_id">
                                                            <option>[--Selecione--]</option>
                                                            @foreach ($states as $optstate)
                                                                <option
                                                                        value="{{ $optstate->id }}"
                                                                        @if(old('state_id') == $optstate->id)
                                                                            selected="true"
                                                                        @elseif($company->city->state->id == $optstate->id)
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
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Cidade:</td>
                                                <td>
                                                    <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}" style="margin: 0">
                                                        <select class="form-control"
                                                                id="city_id"
                                                                title="Cidade"
                                                                name="city_id">
                                                            <option>[--Selecione--]</option>
                                                            @foreach ($cities as $optcity)
                                                                <option value="{{ $optcity->id }}"
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
                                                </td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                        </tbody>
                                    </table>

                                    {{ csrf_field() }}
                                    <input name="_method" type="hidden" value="PUT" />
                                    <button type="submit" class="btn btn-primary">Salvar alterações</button>

                            </div>
                                </div>
                                <div role="tabpanel"
                                     class="tab-pane"
                                     id="name_search">
                                    <table class="table table-user-information">
                                        <tbody>
                                        <tr>
                                            <td>Ramo de atividade:</td>
                                            <td>
                                                <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}" style="margin: 0">
                                                    <select class="form-control"
                                                            title="Ramo de atividade"
                                                            id="category_id"
                                                            name="category_id">
                                                        <option>[--Selecione--]</option>
                                                        @foreach ($categories as $optcategory)
                                                            <option
                                                                    value="{{ $optcategory->id }}"
                                                                    @if(old('category_id') == $optcategory->id)
                                                                        selected="true"
                                                                    @elseif($company->category_id == $optcategory->id)
                                                                        selected="true"
                                                                    @endif
                                                            >{{ ucwords($optcategory->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('category_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('category_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $('#state_id').change(function() {
            var state_id = $('#state_id').val();
            var country_id = 1;

            if (state_id >= 0) {
                $.get('{{ url('/') }}'+'/api/country/' + country_id + '/state/' + state_id + '/cities', function (data) {
                    try {
                        var citiesJson = data;
                        var cbeCity = $('#city_id');
                        cbeCity.empty();
                        cbeCity.append(new Option('[--Selecione--]', '-1'));
                        for (var i = 0, items = citiesJson.length; i < items; i++) {
                            cbeCity.append(new Option(citiesJson[i].name, citiesJson[i].id));

                        }
                    }
                    catch (e) {
                        console.log(e);
                    }

                });
            }
            else
            {
                var cbeCity = $('#city_id');
                cbeCity.empty();
                cbeCity.append(new Option('[--Selecione--]', '-1'));
            }



        });
    </script>

@endsection

