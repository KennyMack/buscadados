@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Detalhes da empresa
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3 col-lg-3 " align="center">
                            <img alt="Logotipo da empresa" src="{{$company->getImage()}}"
                                 class="thumbnail" style="max-width: 250px; max-height: 250px;">
                        </div>
                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>Status:</td>
                                        <td>{{ $company->getStatus() }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Dados</b></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>Razão social:</td>
                                        <td>{{ ucwords($company->companyname) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nome fantasia:</td>
                                        <td>{{ ucwords($company->tradingname) }}</td>
                                    </tr>
                                    <tr>
                                        <td>CNPJ:</td>
                                        <td>{{ $company->cnpjcpf }}</td>
                                    </tr>
                                    <tr>
                                        <td>I.E.:</td>
                                        <td>{{ $company->ie }}</td>
                                    </tr>
                                    <tr>
                                        <td>I.M.:</td>
                                        <td>{{ $company->im }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Contratos:</ b></td>
                                        <td>{{ $company->getNumContracts() }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Usuário</b></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td>Nome:</td>
                                        <td>{{ $company->user->completeName() }}</td>
                                    </tr>
                                    <tr>
                                        <td>E-mail:</td>
                                        <td>{{ $company->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Endereço</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Rua:</td>
                                        <td>{{ $company->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Número:</td>
                                        <td>{{ $company->number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bairro:</td>
                                        <td>{{ $company->district }}</td>
                                    </tr>
                                    <tr>
                                        <td>CEP:</td>
                                        <td>{{ $company->postalnumber }}</td>
                                    </tr>
                                    <tr>
                                        <td>Estado:</td>
                                        <td>{{ isset($company->city) ? $company->city->state->DescriptionInitials() : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cidade:</td>
                                        <td>{{ isset($company->city) ? $company->city->name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Contato</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Telefone:</td>
                                        <td>{{ $company->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>História</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{{ $company->history }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                </tbody>
                            </table>
                            <form method="POST" style="display: inline" action="{{ url('admin/companies/'.$company->id.'/enable' ) }}">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary">Habilitar Cadastro</button>
                            </form>
                            <form method="POST" style="display: inline" action="{{ url('admin/companies/'.$company->id.'/disable' ) }}">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger">Desabilitar Cadastro</button>
                            </form>
                            @foreach($company->companyCategories as $category)
                                <article class="search-result row" >
                                    <div class="col-xs-12 col-sm-3 col-md-3" style="padding-top: 20px">
                                        <img src="{{  $category->category->getMainImage() }}" alt="Image preview"
                                             class="thumbnail center-thumbnail"
                                             style="max-width: 140px; max-height: 110px;">
                                    </div>
                                    <div class="col-xs-12 col-sm-7 col-md-7" style="padding-top: 30px">
                                        <h3 ><b class="black-text">{{ ucwords($category->name) }}</b></h3>
                                        <p class="black-text" ><span>{{ $category->description }} </span></p>
                                        @if ($category->category->type == 1)
                                            <p class="black-text"><strong>Numero de contratos: {{ $category->getNumberContract() }}</strong></p>
                                        @else
                                            <p class="black-text"><strong>{{ $category->value  }}</strong></p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
