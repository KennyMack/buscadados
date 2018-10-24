@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if(Session::has('message_success'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message_success') }}
                            </div>

                        @endif

                        @if (Auth::guest())
                            <p>Seja bem vindo ao CNSF</p>
                        @endif
                        @if (Auth::user()->isAdmin())
                           <p>Seja bem vindo ao CNSF</p>
                        @endif
                        @if (!Auth::guest())
                            @if (!Auth::user()->isAdmin() && Auth::user()->companyIsEnabled())
                                @foreach($categories as $category)
                                    <div class="col-md-4 col-sm-6" style="margin-top: 10px; box-sizing: border-box;">
                                        <div class="col-md-12" style="height: 100px">
                                            <a href="{{ url('search?type=0&id_state=-1&id_city=-1&id_category=').$category->id }}">
                                                <img src="{{ $category->getMainImage() }}"
                                                     alt="{{ $category->name }}"
                                                     class="thumbnail"
                                                     style="width: 80px; height: 80px; margin-left: auto;margin-right: auto;">
                                            </a>
                                        </div>

                                        <div class="col-md-12" style="height: 80px">
                                            <a href="{{ url('search?type=0&id_state=-1&id_city=-1&id_category=').$category->id }}"
                                               class="linkCategory">{{ ucwords($category->name) }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<style type="text/css">
.linkCategory{
text-align: center;
display: block;
}
</style>
@endsection
