@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Busca de Empresas e Serviços
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <ul class="nav nav-pills nav-justified "  role="tablist">
                                <li role="presentation"
                                    @if(isset($type) &&
                                        $type == 0)
                                        class="active"
                                    @elseif(!isset($type))
                                        class="active"
                                    @endif>
                                    <a href="#regional_search" aria-controls="regional_search" role="tab" data-toggle="tab">Busca Regional</a>
                                </li>
                                <li role="presentation"
                                    @if(isset($type) &&
                                        $type == 1)
                                        class="active"
                                    @endif>
                                    <a href="#name_search" aria-controls="name_search" role="tab" data-toggle="tab">Busca por nome</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="tab-content clearfix" style="padding-top: 20px">
                                <div role="tabpanel"
                                     @if(isset($type) &&
                                        $type == 0)
                                        class="tab-pane active"
                                     @elseif(!isset($type))
                                        class="tab-pane active"
                                     @else
                                        class="tab-pane"
                                     @endif

                                     id="regional_search">
                                    <form method="GET" class="form-horizontal"
                                        role="form"
                                        action="{{ url('search') }}">
                                        <input type="hidden" name="type" id="type" value="0" />

                                        <div class="row">
                                            <div class="col-md-4  col-xs-5">
                                                <div class="group">
                                                    <select id="id_state"
                                                            autofocus
                                                            title="Estados"
                                                            class="md"
                                                            name="id_state">
                                                        <option value="-1" selected>UF</option>
                                                        @foreach ($states as $optstate)
                                                            <option value="{{ $optstate->id }}"
                                                            @if(isset($id_state))
                                                                {{ $id_state == $optstate->id ?
                                                                'selected="true"' : ' ' }}
                                                                    @endif
                                                            >{{ ucwords($optstate->DescriptionInitials()) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="highlight"></span>
                                                    <span class="bar"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-xs-7">
                                                <div class="group">
                                                    <select id="id_city"
                                                            title="Cidades"
                                                            class="md"
                                                            name="id_city">
                                                        <option value="-1" selected>TODAS AS CIDADES</option>
                                                    </select>
                                                    <span class="highlight"></span>
                                                    <span class="bar"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!--<div class="row">
                                            <div class="col-md-4  col-xs-5">
                                                <select id="id_state"
                                                        autofocus
                                                        title="Estados"
                                                        class="form-control"
                                                        name="id_state">
                                                    <option value="-1" selected>UF</option>
                                                    @foreach ($states as $optstate)
                                                        <option value="{{ $optstate->id }}"
                                                                    @if(isset($id_state))
                                                                        {{ $id_state == $optstate->id ?
                                                                        'selected="true"' : ' ' }}
                                                                    @endif
                                                        >{{ ucwords($optstate->DescriptionInitials()) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-8 col-xs-7">
                                                <select id="id_city"
                                                        title="Cidades"
                                                       class="form-control"
                                                       name="id_city">
                                                    <option value="-1" selected>TODAS AS CIDADES</option>
                                                </select>
                                            </div>
                                        </div>-->
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="group">
                                                    <select id="id_category"
                                                            title="Categorias"
                                                            class="md"
                                                            name="id_category">
                                                        <option value="-1" selected>TODAS AS ÁREAS</option>
                                                        @foreach ($categories as $optcategory)
                                                            <option value="{{ $optcategory->id }}"
                                                            @if(isset($id_category))
                                                                {{ $id_category == $optcategory->id ?
                                                                'selected="true"' : ' ' }}
                                                                    @endif
                                                            >{{ ucwords($optcategory->categoryname . ' / '. $optcategory->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="highlight"></span>
                                                    <span class="bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="row">
                                            <div class="col-md-12">
                                                <select id="id_category"
                                                        title="Categorias"
                                                        class="form-control"
                                                        name="id_category">
                                                    <option value="-1" selected>TODAS AS ÁREAS</option>
                                                    @foreach ($categories as $optcategory)
                                                        <option value="{{ $optcategory->id }}"
                                                        @if(isset($id_category))
                                                            {{ $id_category == $optcategory->id ?
                                                            'selected="true"' : ' ' }}
                                                                @endif
                                                        >{{ ucwords($optcategory->categoryname . ' / '. $optcategory->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>-->
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button  type="submit" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-search"></i> Buscar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel"
                                     @if(isset($type) &&
                                        $type == 1)
                                        class="tab-pane active"
                                     @else
                                        class="tab-pane"
                                     @endif
                                     id="name_search">
                                    <form method="GET" class="form-horizontal"
                                          role="form"
                                          novalidate
                                          action="{{ url('search') }}">
                                        <input type="hidden" name="type" id="type" value="1" />

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="group">
                                                    <input type="text"
                                                           id="name"
                                                           title="Nome ou organização"
                                                           required
                                                           class="md"
                                                           name="name"
                                                           value="{{ isset($name) ? $name : '' }}"/>
                                                    <span class="highlight"></span>
                                                    <span class="bar"></span>
                                                    <label for="district" class="md">NOME OU ORGANIZAÇÃO</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button  type="submit" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-search"></i> Buscar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($count_results > 0)
                        <strong class="text-danger">{{ $count_results  }}</strong>
                        @if($count_results > 1)
                            Resultados encontrados.
                        @else
                            Resultado encontrado.
                        @endif
                    @else
                        Nenhum resultado encontrado.
                    @endif
                </div>
                <div class="panel-body">
                    <section class="col-xs-12 col-sm-6 col-md-12">
                    @foreach($results as $result)
                        <article class="search-result row" >
                            <div class="col-xs-12 col-sm-12 col-md-3" style="padding-top: 20px">
                                <a href="{{ url('search/'.$result->id) }}" title="{{ $result->companyname }}" >
                                    <img src="{{ $result->getImage()  }}" class="thumbnail" alt="{{ $result->companyname }}" />
                                </a>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-7" style="padding-top: 30px">
                                <h3 ><a href="{{ url('search/'.$result->id) }}" class="black-text" title=""><b class="black-text">{{ ucwords($result->tradingname) }}</b></a></h3>
                                <h4 class="black-text">{{ ucwords($result->companyname) }}</h4>
                                <p class="black-text" ><span>{{ $result->cityStateDescription() }}</span></p>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2" style="padding-left: 0;padding-top: 30px;">
                                <div class="container-button" >

                                    <div class="more-button">
                                        <span class="plus">
                                            <a href="{{ url('search/'.$result->id) }}" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i> info</a>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </article>
                    @endforeach
                    </section>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            {{ $results->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    var cbeCity = $('#id_city');
    var cbeState = $('#id_state');

    function loadCities() {
        if (cbeState.val() > -1) {
            $.get('{{ url('/') }}'+'/api/country/1/state/' + cbeState.val() + '/cities', function (data) {
                try {
                    var citiesJson = data;
                    var cbeCity = $('#id_city');
                    cbeCity.empty();
                    cbeCity.append(new Option('TODAS AS CIDADES', '-1', 'disabled', 'selected'));
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
    }

    function setCity() {
        var id_city = window.getUrlQryParams()['id_city'];

        if (id_city) {

            cbeCity.val(id_city).change();
        }
    }



    cbeState.change(function() {
        var state_id = $('#id_state').val();

        if (state_id >= 0) {
            loadCities();
        }
        else
        {
            cbeCity.empty();
            cbeCity.append(new Option('TODAS AS CIDADES', '-1', 'disabled', 'selected'));
        }

    });
    loadCities();

</script>
<style type="text/css">


    .container-button {
        position:absolute;
        top:0;
        bottom:0;
        width:100%;
        float:left;

    }
    .black-text {
        color: #868686 !important;
        font-weight: bold;
    }
    .black-text:hover {
        color: #4c4c4c !important;
    }

    .more-button {
        height:80%;
        width:80%;
        margin:0 auto;
        margin-top:20%;
        background-color: #03944F;
    }
    .search-result .thumbnail {
        width: 140px;
        height: 140px;
        border-radius: 0 !important;
    }
    .search-result:first-child {
        margin-top: 0 !important;
    }
    .search-result {
        margin-top: 20px;
        background-color: #EDEFE1;
        padding-bottom: 0;
    }
    .search-result .col-md-2 {
        min-height: 140px;

    }
    .search-result ul {
        padding-left: 0 !important;
        list-style: none;

    }
    .search-result ul li {
        font: 400 normal .85em "Roboto",Arial,Verdana,sans-serif;
        line-height: 30px;

    }
    .search-result ul li i {

    }
    .search-result .col-md-7 {
        position: relative;

    }
    .search-result h3 {
        margin-top: 0 !important;
        margin-bottom: 10px !important;

    }
    .search-result h3 > a, .search-result i {
        color: #248dc1 !important;

    }
    .search-result p {

    }

    .search-result span.plus:before {
        content: "";
        display: inline-block;
        height: 38%;
        vertical-align: middle;
    }

    .search-result span.plus {
        color:#fff;
        box-sizing: border-box;
    }
    .search-result span.plus a {
        font-size: 2rem;
        display: block;
        text-align: center;
        vertical-align: middle;
        color:#fff;
        box-sizing: border-box;

    }
    .search-result span.plus a:hover {

    }
    .search-result span.plus a i {
        color: #fff !important;

    }
</style>
@endsection
