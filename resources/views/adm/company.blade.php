<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Valida Eleições - Sistema de Eleições</title>
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <link rel="stylesheet" href="{{ asset('/file/css/global.css') }}">
    </head>
    <body class="w-100" style="background-color: #EEE;">
        <div class="d-flex justify-content-center">
            <div id="msg-popup" class="animated">
                <i></i>
                <span></span>
                <div class="time-bar bar" data-style="smooth"></div>
            </div>
        </div>
        <div id="container-system-adm">
            @include('adm/header')
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Dados Associação</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá cadastrar ou editar dados da Empresa/Associação, <b class="text-danger">somente usuários autorizados</b>, sendo:</p>
                <form id="company-adm" name="company-adm" autocomplete="off" method="PUT">
                @csrf
                @method('PUT')
                    <h6 class="mt-3"><b>Dados primários</b></h6>

                    <div class="row">
                        <div class="col-7">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="company" name="company" placeholder="Nome completo" value="{{ @$company }}" required>
                                <label for="company">Empresa/Associação*</label>
                            </div>
                        </div>

                        <div class="col-5">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control mask" data-ref="cnpj" id="cnpj" name="cnpj" maxlength="14" placeholder="00.000.000/0000-00" value="{{ @$cnpj }}" required>
                                <label for="cnpj">CNPJ <small class="fst-italic">(somente números)</small>*</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control mask" data-ref="phone" id="phone" name="phone" placeholder="" maxlength="20" value="{{ @$phone }}" required>
                                <label for="phone">Telefone <small class="fst-italic">(somente números)</small>*</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="nome@dominio.com.br" value="{{ @$email }}" required>
                                <label for="email">E-mail*</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="responsible" name="responsible" placeholder="Nome completo" value="{{ @$responsible }}" required>
                                <label for="responsible">Responsável*</label>
                            </div>
                        </div>
                    </div>

                    <h6 class="mt-3"><b>Endereço</b></h6>

                    <div class="row">
                        <div class="col-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control mask" data-ref="cep" id="cep" name="cep" value="{{ @$cep }}" placeholder="00000-000">
                                <label for="cep">CEP <small class="fst-italic">(somente números)</small></label>
                            </div>
                        </div>
                        <div class="loader col-1 mt-2 d-none">
                            <div class="spinner-border text-secondary" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                        <div class="col-9"></div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="street" name="street" value="{{ @$street }}" placeholder="Avenida, Alameda, etc">
                                <label for="street">Rua</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="number" name="number" value="{{ @$number }}" placeholder="">
                                <label for="number">Número</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="complement" name="complement" value="{{ @$complement }}" placeholder="apto, sala, galpao, etc">
                                <label for="complement">Complemento</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="{{@$neighborhood }}" placeholder="Vila, Alameda">
                                <label for="neighborhood">Bairro</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="city" name="city" value="{{ @$city }}" placeholder="cidade">
                                <label for="city">Cidade</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <select id="uf" name="uf" class="form-select form-select-lg">
                                <option selected>Selecione o Estado</option>
                                <option @if(@$uf == 'AC') selected="selected" @endif value="AC">AC</option>
                                <option @if(@$uf == 'AL') selected="selected" @endif value="AL">AL</option>
                                <option @if(@$uf == 'AM') selected="selected" @endif value="AM">AM</option>
                                <option @if(@$uf == 'AP') selected="selected" @endif value="AP">AP</option>
                                <option @if(@$uf == 'BA') selected="selected" @endif value="BA">BA</option>
                                <option @if(@$uf == 'CE') selected="selected" @endif value="CE">CE</option>
                                <option @if(@$uf == 'DF') selected="selected" @endif value="DF">DF</option>
                                <option @if(@$uf == 'ES') selected="selected" @endif value="ES">ES</option>
                                <option @if(@$uf == 'ES') selected="selected" @endif value="GO">GO</option>
                                <option @if(@$uf == 'MA') selected="selected" @endif value="MA">MA</option>
                                <option @if(@$uf == 'MG') selected="selected" @endif value="MG">MG</option>
                                <option @if(@$uf == 'MS') selected="selected" @endif value="MS">MS</option>
                                <option @if(@$uf == 'MT') selected="selected" @endif value="MT">MT</option>
                                <option @if(@$uf == 'PA') selected="selected" @endif value="PA">PA</option>
                                <option @if(@$uf == 'PB') selected="selected" @endif value="PB">PB</option>
                                <option @if(@$uf == 'PE') selected="selected" @endif value="PE">PE</option>
                                <option @if(@$uf == 'PI') selected="selected" @endif value="PI">PI</option>
                                <option @if(@$uf == 'PR') selected="selected" @endif value="PR">PR</option>
                                <option @if(@$uf == 'RJ') selected="selected" @endif value="RJ">RJ</option>
                                <option @if(@$uf == 'RN') selected="selected" @endif value="RN">RN</option>
                                <option @if(@$uf == 'RO') selected="selected" @endif value="RO">RO</option>
                                <option @if(@$uf == 'RR') selected="selected" @endif value="RR">RR</option>
                                <option @if(@$uf == 'RS') selected="selected" @endif value="RS">RS</option>
                                <option @if(@$uf == 'SC') selected="selected" @endif value="SC">SC</option>
                                <option @if(@$uf == 'SE') selected="selected" @endif value="SE">SE</option>
                                <option @if(@$uf == 'SP') selected="selected" @endif value="SP">SP</option>
                                <option @if(@$uf == 'TO') selected="selected" @endif value="TO">TO</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="id" name="id" value="{{ @$id }}">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.company.do') }}">
                        <input id="salvar" name="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/company.js') }}"></script>
</html>
