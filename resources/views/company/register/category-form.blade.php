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
                                                            data-description="{{ $category->description }}"
                                                            data-name="{{ ucwords($category->name) }}"
                                                            data-type="{{ $category->type }}"
                                                            @if(old('category_id') == $category->id)
                                                            selected="true"
                                                            @elseif(isset($companyCategory->category_id))
                                                            @if($companyCategory->category_id  == $category->id)
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

                                <div id="fields-contract"
                                     @if (isset($companyCategory->category_id))
                                        style="display: {{ $companyCategory->category->type == '1' ? 'block' : 'none'  }}"
                                     @else
                                        style="display:none"
                                     @endif>
                                    <div class="form-group{{ $errors->has('contract_index') ? ' has-error' : '' }}">
                                        <div class="col-md-2">&nbsp;</div>
                                        <div class="col-md-8">
                                            <div class="group{{ $errors->has('contract_index') ? ' has-error' : '' }}">
                                                <select class="md"
                                                        id="contract_index"
                                                        autofocus
                                                        title="Numero de contratos *"
                                                        name="contract_index">
                                                    <option value="-1">Numero de contratos *</option>
                                                    <option value="0"
                                                        @if(old('contract_index') == '0')
                                                            selected="true"
                                                        @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '0')
                                                            selected="true"
                                                            @endif
                                                        @endif>0 - 1000</option>
                                                    <option value="1"
                                                            @if(old('contract_index') == '1')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '1')
                                                            selected="true"
                                                            @endif
                                                            @endif>1000 - 5000</option>
                                                    <option value="2"
                                                            @if(old('contract_index') == '2')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '2')
                                                            selected="true"
                                                            @endif
                                                            @endif>5000 - 100000</option>
                                                    <option value="3"
                                                            @if(old('contract_index') == '3')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '3')
                                                            selected="true"
                                                            @endif
                                                            @endif>10000 - 20000</option>
                                                    <option value="4"
                                                            @if(old('contract_index') == '4')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '4')
                                                            selected="true"
                                                            @endif
                                                            @endif>20000 - 30000</option>
                                                    <option value="5"
                                                            @if(old('contract_index') == '5')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '5')
                                                            selected="true"
                                                            @endif
                                                            @endif>30000 - 40000</option>
                                                    <option value="6"
                                                            @if(old('contract_index') == '6')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '6')
                                                            selected="true"
                                                            @endif
                                                            @endif>40000 - 50000</option>
                                                    <option value="7"
                                                            @if(old('contract_index') == '7')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '7')
                                                            selected="true"
                                                            @endif
                                                            @endif>50000 - 60000</option>
                                                    <option value="8"
                                                            @if(old('contract_index') == '8')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '8')
                                                            selected="true"
                                                            @endif
                                                            @endif>60000 - 70000</option>
                                                    <option value="9"
                                                            @if(old('contract_index') == '9')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '9')
                                                            selected="true"
                                                            @endif
                                                            @endif>70000 - 80000</option>
                                                    <option value="10"
                                                            @if(old('contract_index') == '10')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '10')
                                                            selected="true"
                                                            @endif
                                                            @endif>80000 - 90000</option>
                                                    <option value="11"
                                                            @if(old('contract_index') == '11')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '11')
                                                            selected="true"
                                                            @endif
                                                            @endif>90000 - 100000</option>
                                                    <option value="12"
                                                            @if(old('contract_index') == '12')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '12')
                                                            selected="true"
                                                            @endif
                                                            @endif>100000 - 130000</option>
                                                    <option value="13"
                                                            @if(old('contract_index') == '13')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '13')
                                                            selected="true"
                                                            @endif
                                                            @endif>130000 - 160000</option>
                                                    <option value="14"
                                                            @if(old('contract_index') == '14')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '14')
                                                            selected="true"
                                                            @endif
                                                            @endif>160000 - 190000</option>
                                                    <option value="15"
                                                            @if(old('contract_index') == '15')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '15')
                                                            selected="true"
                                                            @endif
                                                            @endif>190000 - 220000</option>
                                                    <option value="16"
                                                            @if(old('contract_index') == '16')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '16')
                                                            selected="true"
                                                            @endif
                                                            @endif>220000 - 250000</option>
                                                    <option value="17"
                                                            @if(old('contract_index') == '17')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '17')
                                                            selected="true"
                                                            @endif
                                                            @endif>250000 - 280000</option>
                                                    <option value="18"
                                                            @if(old('contract_index') == '18')
                                                            selected="true"
                                                            @elseif(isset($companyCategory->id))
                                                            @if($companyCategory->contract_index  == '18')
                                                            selected="true"
                                                            @endif
                                                            @endif>280000 - 300000</option>
                                                </select>
                                                <span class="highlight"></span>
                                                <span class="bar"></span>
                                                @if ($errors->has('contract_index'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('contract_index') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="fields-detail"
                                     @if (isset($companyCategory->category_id))
                                         style="display: {{ $companyCategory->category->type == '0' ? 'block' : 'none' }}"
                                     @else
                                         style="display:none"
                                     @endif>
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

                                    <div style="display: none;" class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-md-2">&nbsp;</div>
                                        <div class="col-md-8">
                                            <div class="group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                <input id="name" name="name" class="md" type="hidden" required
                                                       @if($readonlyname == 1)
                                                       readonly
                                                       @endif
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

                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        <div class="col-md-2">&nbsp;</div>
                                        <div class="col-md-8">
                                            <div class="group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                <textarea title="Descrição" rows="8" name="description"
                                                          id="description" class="md"
                                                          required
                                                          @if($readonlydescription == 1)
                                                              readonly
                                                            @endif
                                                >{{ isset($companyCategory->description) ? $companyCategory->description : old('description') }}</textarea>
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
                                                    @endif>
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

    <script type="text/javascript">
        var cbeCategory = $('#category_id');
        var cbeCategorydetail = $('#categorydetail_id');
        var fieldsDetail = $('#fields-detail');
        var fieldsContract = $('#fields-contract');
        var txtDetail = $('#text-detail');
        var txtNameDetail = $('#name');
        var txtDescriptionDetail = $('#description');
        var modal = $('#modal-form');

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

        function loadCategoryDetail(cbeSubCategory, idCategory, categorydetail_id) {
            modal.toggle();
            var uri = '/api/categories/' + idCategory + '/detail';
            /**/

            if (idCategory > -1) {
                var selected = $('#category_id').find('option:selected');
                if (selected.length > 0) {

                    fieldsDetail.css({
                        display: ((selected[0].dataset.type || 0).toString() === '1') ? 'none' : 'block'
                    });

                    fieldsContract.css({
                        display: ((selected[0].dataset.type || 0).toString() === '1') ? 'block' : 'none'
                    });
                }

                window.request._get(uri, function (data) {
                    try {
                        var subCatJson = data;
                        cbeSubCategory.empty();
                        cbeSubCategory.append(new Option('Sub-categoria *', '-1'));
                        for (var i = 0, items = subCatJson.length; i < items; i++) {
                            //cbeSubCategory.append(new Option(subCatJson[i].name, subCatJson[i].id));
                            cbeSubCategory.append('<option  data-description="'+ subCatJson[i].description +'" data-min-value="' +
                                subCatJson[i].minvalue + '" data-max-value="' +subCatJson[i].maxvalue+ '" value="' +
                                subCatJson[i].id + '">' + subCatJson[i].name + '</option>');
                        }

                        setCategoryDetailById(cbeSubCategory, categorydetail_id || -1);
                    }
                    catch (e) {
                        console.log(e);
                    }
                    modal.toggle();
                });
            }
            else {
                clearCategoryDetail(cbeSubCategory);
                //txtNameDetail.removeAttr('disabled');
                //txtDescriptionDetail.removeAttr('disabled');
                txtNameDetail.val('');
                txtDescriptionDetail.val('');
                modal.toggle();
            }

        }

        cbeCategory.change(function (e) {
            console.log('changed');

            var selected = $('#category_id').find('option:selected');
            if (selected.length > 0) {

                fieldsDetail.css({
                    display: ((selected[0].dataset.type || 0).toString() === '1') ? 'none' : 'block'
                });

                fieldsContract.css({
                    display: ((selected[0].dataset.type || 0).toString() === '1') ? 'block' : 'none'
                });
            }

            if ($(this).val() < 0)
                txtDetail.hide(250);

            loadCategoryDetail(cbeCategorydetail, cbeCategory.val());
        });

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