@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 0; border-bottom: none;">
                        <ul class="nav nav-tabs">
                            @if($tabuser)
                                <li><a href="#">Usuário</a></li>
                            @endif
                            <li><a href="{{ $urlcompany }}">Empresa</a></li>
                            <li><a href="{{ $urladdress }}">Endereço</a></li>
                            <li class="active"><a href="{{ $urlcategory }}">Ramo de Atividade</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal"
                              role="form"
                              method="POST"
                              novalidate
                              enctype="multipart/form-data"
                              action="{{ $url }}">
                            {{ csrf_field() }}
                            @if(Session::has('register'))
                                <div class="alert alert-warning alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('register') }}
                                </div>
                            @endif

                            <input type="hidden" name="deletedImage" id="deletedImage"  />

                            @if(Request::is('*/change'))
                                <input name="_method" type="hidden" value="PUT" />
                            @endif
                            <div class="col-md-12 col-lg-12" align="center">
                                <ul id="imageBox"
                                    class="imageBox">
                                    @if(count($images) > 0)
                                        @foreach ($images as $image)
                                            <li class="item-image"
                                                id="btn-image-box-{{ $image->id }}">
                                                <input type="hidden" name="imgdata[]" id="imgdata[]"  data-index-image="{{ $image->id }}"/>
                                                <label class="btn-image" for="image-{{ $image->id }}">
                                                    <img src="{{ $image->imageurl  }}" alt="Image preview"
                                                         class="thumbnail center-thumbnail"
                                                         id="img-upload-{{ $image->id }}"
                                                         style="max-width: 180px; max-height: 150px; min-height: 150px;">
                                                </label>
                                                <input class="inputfile"
                                                       onchange="imageInputFile({{ $image->id }})"
                                                       type="file" id="image-{{ $image->id }}" name="image-{{ $image->id }}">
                                                <button class="btn btn-danger btn-xs"
                                                        style="margin-top: 5px"
                                                        id="btnRemove"
                                                        onclick="removeItem({{ $image->id }}, false); return false;"
                                                        type="button"
                                                        data-index-image="{{ $image->id }}">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </button>
                                            </li>
                                        @endforeach
                                    @elseif(count($imgtemp) <= 0)
                                        <li class="item-image"
                                            id="btn-image-box-0">
                                            <input type="hidden" name="imgdata[]" id="imgdata[]" data-index-image="0" />
                                            <label class="btn-image" for="image-0">
                                                <img src="{{ asset('/assets/img/category-no-image.png')  }}" alt="Image preview"
                                                     class="thumbnail center-thumbnail"
                                                     id="img-upload-0"
                                                     style="max-width: 180px; max-height: 150px; min-height: 150px;">
                                            </label>
                                            <input class="inputfile"
                                                   onchange="imageInputFile(0)"
                                                   type="file" id="image-0" name="image-0">
                                            <button class="btn btn-danger btn-xs"
                                                    style="margin-top: 5px"
                                                    id="btnRemove"
                                                    onclick="removeItem(0, false); return false;"
                                                    type="button"
                                                    data-index-image="0">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </li>
                                    @endif
                                    @if(count($imgtemp) > 0)
                                        @foreach ($imgtemp as $image)
                                            <li class="item-image"
                                                id="btn-image-box-{{ $image->id }}">
                                                <input type="hidden"
                                                       name="imgdata[]"
                                                       id="imgdata[]"
                                                       value="{{ $image->image  }}"
                                                       data-index-image="{{ $image->id }}"/>
                                                <label class="btn-image" for="image-{{ $image->id }}">
                                                    <img src="{{ $image->image  }}" alt="Image preview"
                                                         class="thumbnail center-thumbnail"
                                                         id="img-upload-{{ $image->id }}"
                                                         style="max-width: 180px; max-height: 150px; min-height: 150px;">
                                                </label>
                                                <input class="inputfile"
                                                       onchange="imageInputFile({{ $image->id }})"
                                                       type="file" id="image-{{ $image->id }}" name="image-{{ $image->id }}">
                                                <button class="btn btn-danger btn-xs"
                                                        style="margin-top: 5px"
                                                        id="btnRemove"
                                                        onclick="removeItem({{ $image->id }}, true); return false;"
                                                        type="button"
                                                        data-index-image="{{ $image->id }}">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </button>
                                            </li>
                                        @endforeach
                                    @endif

                                    <li class="item-image add"
                                        id="btn-add-box">
                                        <div class="btn-add"
                                             id="btnAdd">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                           <!-- <div class="col-md-2 col-lg-2 " align="center">
                                <input type="hidden" name="imgdata" id="imgdata"  value="{ old('imgdata') }}"/>

                                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                    <div class="col-md-4 col-xs-6 col-xs-offset-3 col-md-offset-4 img-container">
                                        <label class="btn-image" for="image">
                                            <img src="{ $image  }}"
                                                 alt="Image preview"
                                                 class="thumbnail center-thumbnail"
                                                 id="img-upload"
                                                 style="max-width: 180px; max-height: 150px; min-height: 150px;">
                                        </label>
                                        <input class="inputfile" type="file" id="image" name="image">
                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>-->
                            <div class="col-md-12">
                                &nbsp;
                            </div>

                            <div class="col-md-offset-1 col-md-10 col-lg-10 ">

                                <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-8">
                                        <div class="group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                            <select class="md"
                                                    id="category_id"
                                                    autofocus
                                                    title="Categoria"
                                                    name="category_id">
                                                <option value="-1">Categoria *</option>
                                                @foreach ($categories as $category)
                                                    <option
                                                            value="{{ $category->id }}"
                                                            @if(old('category_id') == $category->id)
                                                            selected="true"
                                                            @elseif(isset($companyCategory->categoryDetail->category->id))
                                                            @if($companyCategory->categoryDetail->category->id  == $category->id)
                                                            selected="true"
                                                            @endif
                                                            @endif
                                                    >{{ ucwords($category->name) }}</option>
                                                @endforeach
                                            </select>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            @if ($errors->has('category_id'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('category_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('categorydetail_id') ? ' has-error' : '' }}">
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-8">
                                        <div class="group{{ $errors->has('categorydetail_id') ? ' has-error' : '' }}">
                                            <select class="md"
                                                    id="categorydetail_id"
                                                    autofocus
                                                    title="Sub-categoria *"
                                                    name="categorydetail_id">
                                                <option data-min-value="0"
                                                        data-max-value="0"
                                                        value="-1">Sub-categoria *</option>
                                                @foreach ($categoriesdetail as $category)
                                                    <option
                                                            value="{{ $category->id }}"
                                                            data-min-value="{{ $category->minvalue }}"
                                                            data-max-value="{{ $category->maxvalue }}"
                                                            @if(old('categorydetail_id') == $category->id)
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->categorydetail_id  == $category->id)
                                                            selected="true"
                                                            @endif
                                                            @endif
                                                    >{{ ucwords($category->categoryname . ' / '. $category->name) }}</option>
                                                @endforeach
                                            </select>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            @if ($errors->has('categorydetail_id'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('categorydetail_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!--<div class="form-group{{ $errors->has('categorydetail_id') ? ' has-error' : '' }}">
                                    <label for="state_id" class="col-md-4 control-label">Categorias *</label>
                                    <div class="col-md-6">
                                        <select class="form-control"
                                                id="categorydetail_id"
                                                autofocus
                                                name="categorydetail_id">
                                            <option>[--Selecione--]</option>
                                            @foreach ($categories as $category)
                                                <option
                                                        value="{{ $category->id }}"
                                                        data-min-value="{{ $category->minvalue }}"
                                                        data-max-value="{{ $category->maxvalue }}"
                                                        @if(old('categorydetail_id') == $category->id)
                                                        selected="true"
                                                        @elseif(isset($companyCategory->id))
                                                        @if($companyCategory->categorydetail_id  == $category->id)
                                                        selected="true"
                                                        @endif
                                                        @endif
                                                >{{ ucwords($category->categoryname . ' / '. $category->name) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('categorydetail_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('categorydetail_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>-->

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-8">
                                        <div class="group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <input id="name" name="name" class="md" type="text" required
                                                   value="{{ isset($companyCategory->name) ? $companyCategory->name : old('name') }}">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="name" class="md">Nome do serviço *</label>
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <!--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} ">
                                    <label for="name" class="col-md-4 control-label">Nome do serviço *</label>

                                    <div class="col-md-6">
                                        <input id="name" autofocus type="text" class="form-control" name="name"
                                               value="{{ isset($companyCategory->name) ? $companyCategory->name : old('name') }}">

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>-->

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-8">
                                        <div class="group{{ $errors->has('description') ? ' has-error' : '' }}">
                                            <textarea title="Descrição" rows="8" name="description"  id="description" class="md"  required >{{ isset($companyCategory->description) ? $companyCategory->description : old('description') }}</textarea>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="description" class="md">Descrição *</label>
                                            @if ($errors->has('description'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!--<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description" class="col-md-4 control-label">Descrição *</label>

                                    <div class="col-md-6">
                                        <textarea class="form-control" rows="8" name="description"  id="description">{{ isset($companyCategory->description) ? $companyCategory->description : old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>-->


                                <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-8">
                                        <div class="group{{ $errors->has('value') ? ' has-error' : '' }}">
                                            <input id="value" name="value" class="md" type="text" required
                                                   value="{{ isset($companyCategory->value) ? $companyCategory->value : old('value') }}">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="value" class="md">Valor *</label>
                                            <span id="text-detail" class="help-block" >
                                                Valores entre <span id="text-det-value"></span>.
                                            </span>
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('value') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!--<div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                                    <label for="value" class="col-md-4 control-label">Valor *</label>

                                    <div class="col-md-6">
                                        <input id="value" type="text" class="form-control" name="value"
                                               value="{{ isset($companyCategory->value) ? $companyCategory->value : old('value') }}">

                                        <span id="text-detail" class="help-block" >
                                            Valores entre <span id="text-det-value"></span>.
                                        </span>
                                        @if ($errors->has('value'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('value') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>-->

                                <input type="hidden" name="isactive" id="isactive" value="0">
                                <div class="form-group{{ $errors->has('isactive') ? ' has-error' : '' }}">
                                    <div class="checkbox">
                                        <div class="col-md-2">&nbsp;</div>
                                        <div class="col-md-4">
                                            <label>
                                                <input id="isactive"
                                                       type="checkbox"
                                                       name="isactive"
                                                       @if (isset($companyCategory->isactive))

                                                       {{ $companyCategory->isactive == 1 ? 'checked' : ''}}
                                                       @else
                                                       checked
                                                       @endif
                                                       value="1"> Ativo
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-2">
                                        <a class="btn btn-default"
                                           @if(Request::is('*/profile/*'))
                                                href="{{ url('/companies/profile/category')  }}"
                                           @else
                                                href="{{ url('/register/category') }}"
                                           @endif>
                                            Cancelar
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">
                                            @if(Request::is('*/change'))
                                                <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                                            @else
                                                <i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar Mais
                                            @endif
                                        </button>
                                    </div>
                                </div>
                                <p class="help-block">* Campos obrigatórios</p>
                            </div>

                        </form>
                        <hr>
                        <section class="col-xs-12 col-sm-12 col-md-12">
                            @foreach($company->companyCategories as $category)
                                <article class="search-result row" >
                                    <div class="col-xs-12 col-sm-3 col-md-3" style="padding-top: 20px">
                                        <img src="{{  $category->getMainImage() }}" alt="Image preview"
                                             class="thumbnail center-thumbnail"
                                             style="max-width: 140px; max-height: 110px;">
                                    </div>
                                    <div class="col-xs-12 col-sm-7 col-md-7" style="padding-top: 30px">
                                        <h3 ><b class="black-text">{{ ucwords($category->name) }}</b></h3>
                                        <p class="black-text" ><span>{{ $category->description  }}</span></p>
                                        <p class="black-text"><strong>{{ $category->value  }}</strong></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-2 col-md-2" style="padding-left: 0;padding-top: 30px;">
                                        <div class="col-md-12 col-sm-12 col-xs-6 text-center">
                                            <a
                                                    @if(Request::is('*/profile/*'))
                                                    href="{{ url('companies/profile/category/'.$category->id.'/change')  }}"
                                                    @else
                                                    href="{{ url('register/category/'.$category->id.'/change')  }}"
                                                    @endif
                                                    class="btn btn-default">
                                                <i class="glyphicon glyphicon-pencil"></i> Editar
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-sm-12 hidden-xs">
                                            &nbsp;
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-6 text-center">
                                            <form style="display: inline;"
                                                  method="POST"
                                                  @if(Request::is('*/profile/*'))
                                                  action="{{ url('companies/profile/category/'.$category->id.'/remove')  }}"
                                                  @else
                                                  action="{{ url('register/category/'.$category->id.'/remove')  }}"
                                                    @endif
                                            >
                                                <input name="_method" type="hidden" value="DELETE">
                                                {{ csrf_field() }}
                                                <button class="btn btn-danger"
                                                        name="remove_levels"
                                                        type="submit">
                                                    <i class="glyphicon glyphicon-trash"></i> Remover
                                                </button>
                                            </form>




                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </section>
                        <hr>

                        <div class="col-md-12">
                            &nbsp;
                        </div>

                        <form class="form-horizontal"
                              role="form"
                              method="POST"
                              @if(Request::is('*/profile/*'))
                              action="{{ url('companies/profile/category/save') }}"
                              @else
                              action="{{ url('register/category/save') }}"
                              @endif
                        >

                            {{ csrf_field() }}

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    @if(Request::is('*/profile/*'))
                                        <button type="submit" class="btn btn-primary">
                                            <i class="glyphicon glyphicon-floppy-disk"></i> Salvar alterações
                                        </button>
                                    @else
                                        <a href="{{ url('/register/address')  }}" class="btn btn-default">
                                            <i style="font-size: 1.1rem" class="fa fa-btn fa-chevron-left"></i> Voltar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            Concluir
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="confirmModal" style="display: none; z-index: 1050;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="confirmMessage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="confirmOk">Ok</button>
                    <button type="button" class="btn btn-default" id="confirmCancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        .imageBox {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            list-style: none;
            padding: 0;
            margin: 0;
            display: table;
            float: left;
        }
        .item-image {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 0;
            margin: 5px;
            float: left;
            display: inline-block;
        }

        .item-image.add {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            height: 160px;
        }

        .btn-add {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            vertical-align: middle;
            cursor: pointer;
            padding: 15px 18px 15px 18px;
            margin: 60px 15px 0 15px;
            border: 1px solid #ddd;
            border-radius: 35px;
        }


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
        .search-result .grid-thumb {
            max-width: 150px;
            margin-right: auto;
            margin-left: auto;
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

        .center-thumbnail {
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
            display: inline;
        }
        .inputfile {
            display: none!important;
        }
    </style>
    <script type="text/javascript">
        var cbeCategory = $('#category_id');
        var cbeCategorydetail = $('#categorydetail_id');
        var txtDetail = $('#text-detail');

        var categorydetail_id = '{{ isset($companyCategory->categorydetail_id) ? $companyCategory->categorydetail_id : old('categorydetail_id') }}';
        $(document).ready( function() {
            var txtDetailContent = $('#text-det-value');

            if (cbeCategorydetail.val() > -1 && cbeCategory.val() > -1 )
            {
                var minValue = Number(cbeCategorydetail.find(':selected').data("min-value"));
                var maxValue = Number(cbeCategorydetail.find(':selected').data("max-value"));

                console.log('minValue');

                var min = window.format.formatText(minValue.toFixed(2)) || 0;
                var max = window.format.formatText(maxValue.toFixed(2)) || 0;

                txtDetailContent.empty().append(
                    min + ' e ' +
                    max);

                if (cbeCategorydetail.val() > -1){
                    txtDetail.css({
                        'opacity': '0',
                        'display': 'block'
                    })
                        .show()
                        .animate({
                            opacity: 1
                        });
                }
                else
                    txtDetail.hide(250);

            }
            else
                txtDetail.hide(250);
        });
        function clearCategoryDetail(input) {
            input.empty();
            input.append('<option data-min-value="0" data-max-value="0" value="-1">Sub-categoria *</option>');
        }

        function setCategoryDetailById(input, value) {
            input.val(value).change();
        }

        cbeCategory.change(function () {
            console.log('0');
            if ($(this).val() < 0)
                txtDetail.hide(250);
        });


        function loadCategoryDetail(cbeSubCategory, idCategory, categorydetail_id) {
            var uri = '/api/categories/' + idCategory + '/detail';

            if (idCategory > -1) {
                window.request._get(uri, function (data) {
                    try {
                        var subCatJson = data;
                        cbeSubCategory.empty();
                        cbeSubCategory.append(new Option('Sub-categoria *', '-1'));
                        for (var i = 0, items = subCatJson.length; i < items; i++) {
                            //cbeSubCategory.append(new Option(subCatJson[i].name, subCatJson[i].id));
                            cbeSubCategory.append('<option data-min-value="' + subCatJson[i].minvalue + '" data-max-value="' +subCatJson[i].maxvalue+ '" value="' + subCatJson[i].id + '">' + subCatJson[i].name + '</option>');

                        }

                        setCategoryDetailById(cbeSubCategory, categorydetail_id || -1);
                    }
                    catch (e) {
                        console.log(e);
                    }
                });
            }
            else
                clearCategoryDetail(cbeSubCategory);

        }

        cbeCategory.change(function() {
            loadCategoryDetail(cbeCategorydetail, cbeCategory.val());
        });

        console.log(categorydetail_id);

        loadCategoryDetail(cbeCategorydetail, cbeCategory.val(), categorydetail_id);

        function removeItem(value, isTemp) {
            var imageIndex = value;
            var deletedImage = $('#deletedImage');
            var deletedImageTemp = $('#deletedImageTemp');

            if (!isTemp)
                deletedImage.val(deletedImage.val() + value + '-');

            if (Number(imageIndex) > 0)
                $('#btn-image-box-' + imageIndex).remove();
        }

        function imageInputFile(value) {
            console.log(value);
            var imgLogo = $('#img-upload-' + value);
            var imgFile = $('#image-' + value);
            var imgHiddenFields = $('input[type=hidden][name="imgdata[]"]');
            var imgHidden = null;


            $.each(imgHiddenFields, function() {
                if (value.toString() === $(this).data('index-image').toString())
                    imgHidden = $(this);
            });

            readURL(imgFile[0], imgLogo, imgHidden);
        }

        function readURL(input, img, inputData) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    img.attr('src', e.target.result);
                    inputData.val(e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }


    </script>
@endsection

@section('import')
    <script src="{{ asset('js/core/request.core.js') }}"></script>
    <script src="{{ asset('libs/jquery.maskmoney.js') }}"></script>
    <script src="{{ asset('js/forms/validation/validate.js') }}"></script>
    <script src="{{ asset('js/forms/validation/format.js') }}"></script>
    <script src="{{ asset('js/forms/image/image-field.js') }}"></script>
    <script src="{{ asset('js/forms/modal/confirm-form.js') }}"></script>
    <script src="{{ asset('js/forms/company/category.form.js') }}"></script>
@endsection