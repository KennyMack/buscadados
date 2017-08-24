@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form class="form-horizontal"
                      role="form"
                      novalidate
                      method="POST"
                      name="frmCompany"
                      enctype="multipart/form-data"
                      @if(Request::is('*/profile/*'))
                      action="{{ url('companies/profile/company/save') }}"
                      @else
                      action="{{ url('register/company/save') }}"
                      @endif
                >
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 0; border-bottom: none;">
                            <ul class="nav nav-tabs">
                                @if($tabuser)
                                    <li><a href="#">Usuário</a></li>
                                @endif
                                <li class="active"><a href="{{ $urlcompany }}">Empresa</a></li>
                                <li><a href="{{ $urladdress }}">Endereço</a></li>
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



                            <input type="hidden" name="imgdata" id="imgdata"  value="{{ old('imgdata') }}"/>

                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <div class="col-md-4 col-xs-6 col-xs-offset-3 col-md-offset-4 img-container">
                                    <label class="btn-image" for="image">
                                        <img src="{{ $image  }}"
                                             alt="Image preview"
                                             class="thumbnail"
                                             id="img-upload"
                                             style="width: 200px; height: 200px">
                                    </label>
                                    <input class="inputfile" type="file" id="image" name="image">
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('companyname') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('companyname') ? ' has-error' : '' }}">
                                        <input id="companyname" name="companyname" class="md" type="text" required
                                               autofocus
                                               value="{{ isset($company->companyname) ? $company->companyname : old('companyname') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="companyname" class="md">Razão Social *</label>
                                        @if ($errors->has('companyname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('companyname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

<!--
                            <div class="form-group{{ $errors->has('companyname') ? ' has-error' : '' }}">
                                <label for="companyname" class="col-md-4 control-label">Razão Social</label>

                                <div class="col-md-6">
                                    <input id="companyname" type="text" class="form-control" name="companyname"
                                           autofocus
                                           value="{{ isset($company->companyname) ? $company->companyname : old('companyname') }}">

                                    @if ($errors->has('companyname'))
                                        <span class="help-block">
                                <strong>{{ $errors->first('companyname') }}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>-->


                            <div class="form-group{{ $errors->has('tradingname') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('tradingname') ? ' has-error' : '' }}">
                                        <input id="tradingname" name="tradingname" class="md" type="text" required
                                               value="{{ isset($company->tradingname) ? $company->tradingname : old('tradingname') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="tradingname" class="md">Nome Fantasia *</label>
                                        @if ($errors->has('tradingname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('tradingname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                                <!--
                            <div class="form-group{{ $errors->has('tradingname') ? ' has-error' : '' }}">
                                <label for="tradingname" class="col-md-4 control-label">Nome Fantasia</label>

                                <div class="col-md-6">
                                    <input id="tradingname" type="text" class="form-control" name="tradingname"
                                           value="{{ isset($company->tradingname) ? $company->tradingname : old('tradingname') }}">

                                    @if ($errors->has('tradingname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('tradingname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>-->

                            <div class="form-group{{ $errors->has('cnpjcpf') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('cnpjcpf') ? ' has-error' : '' }}">
                                        <input id="cnpjcpf" name="cnpjcpf" class="md" type="text" required
                                               maxlength="18"
                                               value="{{ isset($company->cnpjcpf) ? $company->cnpjcpf : old('cnpjcpf') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="cnpjcpf" class="md">CNPJ *</label>
                                        @if ($errors->has('cnpjcpf'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cnpjcpf') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!--<div class="form-group{{ $errors->has('cnpjcpf') ? ' has-error' : '' }}">
                                <label for="cnpjcpf" class="col-md-4 control-label">CNPJ</label>

                                <div class="col-md-6">
                                    <input id="cnpjcpf" type="text" class="form-control" name="cnpjcpf"
                                           maxlength="18"
                                           value="{{ isset($company->cnpjcpf) ? $company->cnpjcpf : old('cnpjcpf') }}">

                                    @if ($errors->has('cnpjcpf'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cnpjcpf') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>-->

                            <div class="form-group{{ $errors->has('ie') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('ie') ? ' has-error' : '' }}">
                                        <input id="ie" name="ie" class="md" type="text" required
                                               value="{{ isset($company->ie) ? $company->ie : old('ie') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="ie" class="md">I.E.</label>
                                        @if ($errors->has('ie'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('ie') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                                <!--
                            <div class="form-group{{ $errors->has('ie') ? ' has-error' : '' }}">
                                <label for="ie" class="col-md-4 control-label">I.E.</label>

                                <div class="col-md-6">
                                    <input id="ie" type="text" class="form-control" name="ie"
                                           value="{{ isset($company->ie) ? $company->ie : old('ie') }}">

                                    @if ($errors->has('ie'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ie') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>-->

                            <div class="form-group{{ $errors->has('im') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('im') ? ' has-error' : '' }}">
                                        <input id="im" name="im" class="md" type="text" required
                                               value="{{ isset($company->im) ? $company->im : old('im') }}">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="im" class="md">I.M.</label>
                                        @if ($errors->has('im'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('im') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!--<div class="form-group{{ $errors->has('im') ? ' has-error' : '' }}">
                                <label for="im" class="col-md-4 control-label">I.M.</label>

                                <div class="col-md-6">
                                    <input id="im" type="text" class="form-control" name="im"
                                           value="{{ isset($company->im) ? $company->im : old('im') }}">

                                    @if ($errors->has('im'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('im') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>-->


                            <div class="form-group{{ $errors->has('history') ? ' has-error' : '' }}">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                    <div class="group{{ $errors->has('history') ? ' has-error' : '' }}">
                                        <textarea rows="8" name="history"  id="history" class="md"  required >{{ isset($company->history) ? $company->history : old('history') }}</textarea>
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="history" class="md">Historia</label>
                                        @if ($errors->has('im'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('history') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!--<div class="form-group">
                                <label for="history" class="col-md-4 control-label">Historia:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="8" name="history"  id="history">{{ isset($company->history) ? $company->history : old('history') }}</textarea>
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

        //valida numero inteiro com mascara
        /*function mascaraInteiro(){

            if (event.keyCode < 48 || event.keyCode > 57){
                event.returnValue = false;
                return false;
            }
            return true;
        }

        function MascaraCNPJ(cnpj){
            e = window.event;
            if(!window.validate.isInteger(cnpj)){
                e.returnValue = false;
                console.log('12');
            }
            return formataCampo(cnpj, '00.000.000/0000-00', e);
        }

        //valida o CNPJ digitado
        function ValidarCNPJ(ObjCnpj){
            var cnpj = ObjCnpj.value;
            var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
            var dig1= new Number;
            var dig2= new Number;

            exp = /\.|\-|\//g
            cnpj = cnpj.toString().replace( exp, "" );
            var digito = Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));

            for(i = 0; i<valida.length; i++){
                dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);
                dig2 += cnpj.charAt(i)*valida[i];
            }
            dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
            dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));

            if(((dig1*10)+dig2) != digito)
                console.log('CNPJ Invalido!');

        }

        //formata de forma generica os campos
        function formataCampo(campo, Mascara, evento) {
            var boleanoMascara;

            var Digitato = evento.keyCode;
            exp = /\-|\.|\/|\(|\)| /g
            campoSoNumeros = campo.value.toString().replace( exp, "" );

            var posicaoCampo = 0;
            var NovoValorCampo="";
            var TamanhoMascara = campoSoNumeros.length;

            if (Number(Digitato) !== 8) { // backspace
                for(i=0; i<= TamanhoMascara; i++) {
                    boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                        || (Mascara.charAt(i) == "/"))
                    boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(")
                        || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))
                    if (boleanoMascara) {
                        NovoValorCampo += Mascara.charAt(i);
                        TamanhoMascara++;
                    }else {
                        NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
                        posicaoCampo++;
                    }
                }
                campo.value = NovoValorCampo;
                return true;
            }else {
                return true;
            }
        }*/

        $(document).ready( function() {
            /*$('#cnpjcpf').on('keypress', function(event) {
                if(!window.validate.isInteger(event)){
                    event.returnValue = false;
                    console.log('12');
                    return false;
                }
                return window.format.formatField(this, '00.000.000/0000-00', event);
            });

            $('#cnpjcpf').on('blur', function(event) {
                if (window.validate.isCNPJ($('#cnpjcpf').val()))
                    console.log('valido');
                else
                    console.log('invalido');
            });*/





            /*function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload').attr('src', e.target.result);
                        $('#imgdata').val(e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image").change(function(){
                readURL(this);
            });*/
        });


    </script>

    <style type="text/css">
        .thumbnail {
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
@endsection

@section('import')
    <script src="{{ asset('js/forms/validation/validate.js') }}"></script>
    <script src="{{ asset('js/forms/validation/format.js') }}"></script>
    <script src="{{ asset('js/forms/image/image-field.js') }}"></script>
    <script src="{{ asset('js/forms/company/company.form.js') }}"></script>
@endsection