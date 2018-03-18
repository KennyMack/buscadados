@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Resultado
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <img src="{{ $company->getImage() }}"
                                     alt="{{ucwords($company->tradingname)}}"
                                     class="thumbnail"
                                     id="img-upload"
                                     style="width: 180px; height: 180px; margin-left: auto;margin-right: auto;">
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <h3><b class="black-text">{{ ucwords($company->tradingname) }}</b></h3>
                                <h4 class="black-text">{{ ucwords($company->companyname) }}</h4>
                                <p class="black-text" ><span>{{ $company->cityStateDescription() }}</span></p>
                                <p class="black-text" ><span>{{ $company->user->email }}</span></p>
                                <a class="black-text" href="http://{{ $company->site }}" target="_blank"><span>{{ $company->site }}</span></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="black-text" ><span>{{ ucwords($company->address) }}, {{ ucwords($company->number) }}, {{ ucwords($company->city->name) }} - {{ strtoupper($company->city->state->initials) }}</span></p>
                               @if($company->phone !== '')
                                    <p>Fone: {{ $company->phone }}</p>
                                @endif
                                @if($company->cellphone !== '')
                                    <p>Cel.: {{ $company->cellphone }}</p>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <iframe frameborder="0" style="border:0; width: 100%; min-height: 220px"
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBUQRmkZstz6HNkR_3hCm8YADiUZyPACN8&q={{ str_replace(' ',  '+', $company->address) }},{{ $company->number }},{{ str_replace(' ', '+', $company->city->name)  }}+{{ $company->city->state->initials }}" allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="black-text">Sobre nós</h4>
                                <p class="black-text">{{ $company->history }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                @foreach($company->companyCategories as $category)
                                    @if($category->isactive == 1 &&
                                        $category->categorydetail_id != null)
                                        <div class="col-md-4 col-sm-6" style="margin-top: 10px; box-sizing: border-box;">
                                            <div class="col-md-12" style="height: 210px">
                                                <img src="{{ $category->getMainImage() }}"
                                                     alt="{{$category->name}}"
                                                     class="thumbnail"
                                                     id="img-upload"
                                                     style="width: 180px; height: 180px; margin-left: auto;margin-right: auto;">

                                            </div>
                                            <h3><a href="{{ url('search/'.$category->id).'/detail' }}">
                                                <b class="black-text">{{$category->name}}</b></a></h3>
                                            <p class="black-text" style="height: 100px; overflow-x: auto" >{{$category->description}}</p>
                                            <hr>
                                            <p class="lead"><b>Valor</b><br>
                                            <b>R$ {{ $category->value }}</b></p>
                                            <!--<p><a class="btn btn-primary" style="display: block" href="#" role="button">Comprar</a></p>-->
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
