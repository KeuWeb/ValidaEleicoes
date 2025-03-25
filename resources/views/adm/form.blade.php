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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Forma de Eleição</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá determinar as formas de Eleição oferecidas pelo Sistema, <b class="fst-italic text-danger">somente usuários autorizados</b>, sendo:</p>
                <form id="form-adm" name="form-adm" autocomplete="off">
                @csrf
                @method('PUT')
                    <h5 class="mt-3"><b>Localidades</b></h5>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="local" id="local1" value="1" <?php if (empty($local) || @$local == 1) { ?>checked<?php } ?>>
                            <label class="form-check-label" for="local1">
                                <b class="fw-bold text-dark">Eleição para apenas uma localidade (padrão)</b>
                            </label>
                            <p class="fs-6">Essa opção só contempla a eleição para uma zona eleitoral (localidade).</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="local" id="local2" value="2" @if (!empty($local) && @$local == 2) checked @endif>
                            <label class="form-check-label" for="local2">
                                <b class="fw-bold text-dark">Eleição para muitas localidades</b>
                            </label>
                            <p class="fs-6">Essa opção contempla a eleição para mais de uma zona eleitoral (localidade).</p>
                        </div>
                    </div>

                    <h5 class="mt-4"><b>Categorias</b></h5>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="category" name="category" @if (!empty($category) && @$category == 1) checked @endif>
                        <label class="form-check-label" for="category">
                            <b class="fw-bold text-dark">Eleição por categorias</b>
                        </label>
                        <p class="fs-6">Essa opção ativa a eleição separada por categorias, ou seja, os eleitores somente votam por candidatos de sua categoria.</p>
                    </div>

                    <h5 class="mt-4"><b>Avaliações</b></h5>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="aval" id="aval1" value="1" @if (empty($aval) || @$aval == 1) checked @endif>
                            <label class="form-check-label" for="aval1">
                                <b class="fw-bold text-dark">Sem avaliação de Comitê (padrão)</b>
                            </label>
                            <p class="fs-6">Caso a eleição esteja com a opção de indicação ativa, não será permitido a avaliação/aprovação do comitê para prosseguir com a eleição com os indicados vencedores.</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="aval" id="aval2" value="2" @if (!empty($aval) && @$aval == 2) checked @endif>
                            <label class="form-check-label" for="aval2">
                                <b class="fw-bold text-dark">Com avaliação de Comitê</b>
                            </label>
                            <p class="fs-6">Caso a eleição esteja com a opção de indicação ativa, somente com a avaliação/aprovação dos indicados pelo comitê a eleição é liberada/continuada.</p>
                        </div>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.form.do') }}">
                        <input id="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/form.js') }}"></script>
</html>
