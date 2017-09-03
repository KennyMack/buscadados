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
                                <img src="{{ $companyCategory->getMainImage() }}"
                                     alt="{{ucwords($companyCategory->name)}}"
                                     class="thumbnail"
                                     id="img-upload"
                                     style="width: 180px; height: 180px; margin-left: auto;margin-right: auto;">
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <div class="col-md-12 col-sm-12">
                                    <h3><b class="black-text">{{ ucwords($companyCategory->name) }}</b></h3>
                                    <h4 class="black-text" ><b>R$ {{ $companyCategory->value }}</b></h4>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <p><a class="btn btn-primary" style="display: block" href="#" role="button">Comprar</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="black-text">Detalhes</h4>
                                <p class="black-text">{{ $companyCategory->description }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @foreach($images as $catimage)
                                @if($companyCategory->getMainImageId() != $catimage->id)
                                    <div class="col-md-4 col-sm-6" style="margin-top: 10px; box-sizing: border-box;">
                                        <div class="col-md-12" style="height: 210px">
                                            <img src="{{ $catimage->imageurl }}"
                                                 alt="{{$companyCategory->name}}"
                                                 class="thumbnail"
                                                 id="img-upload"
                                                 style="width: 180px; height: 180px; margin-left: auto;margin-right: auto;">

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
