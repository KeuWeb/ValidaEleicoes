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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Tipo de Eleição</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá determinar qual tipo de Eleição é oferecida pelo Sistema (<b class="fst-italic text-danger">somente usuários autorizados</b>). Abaixo segue opções liberadas:</p>
                <form id="type-adm" name="type-adm" autocomplete="off">
                @csrf
                @method('PUT')
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type1" value="1" @if((empty($idType)) || (empty(!$idType) && $idType == 1)) checked @endif>
                            <label class="form-check-label" for="type1">
                                <b class="fw-bold text-dark">Eleição sem 2º Turno (padrão)</b>
                            </label>
                            <p class="fs-6">Essa opção só contempla a eleição em si não tendo a opção para um segundo turno, ou seja, nesta opção é decidido já no primeiro turno.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type2" value="2" @if(empty(!@$idType) && @$idType == 2) checked @endif>
                            <label class="form-check-label" for="type2">
                                <b class="fw-bold text-dark">Eleição com 2º Turno</b>
                            </label>
                            <p class="fs-6">Essa opção contempla a eleição com segundo turno, ou seja, nesta opção é decidido tanto primeiro turno como no segundo, caso houver o mesmo.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type3" value="3" @if(empty(!@$idType) && @$idType == 3) checked @endif>
                            <label class="form-check-label" for="type3">
                                <b class="fw-bold text-dark">Indicação + Eleição sem 2º Turno</b>
                            </label>
                            <p class="fs-6">Essa opção permite uma pré eleição onde é feito as indicações de candidatos e após essa campanha a eleição é liberada com os indicados selecionados sendo que, nesta opção não há segundo turno.</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type4" value="4" @if(empty(!@$idType) && @$idType == 4) checked @endif>
                            <label class="form-check-label" for="type4">
                                <b class="fw-bold text-dark">Indicação + Eleição com 2º Turno</b>
                            </label>
                            <p class="fs-6">Essa opção permite uma pré eleição onde é feito as indicações de candidatos e após essa campanha a eleição é liberada com os indicados selecionados sendo que, nesta opção possui segundo turno caso houver o mesmo.</p>
                        </div>
                    </div>
                    <div class="mt-3 gap-2">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.type.do') }}">
                        <input id="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/type.js') }}"></script>
</html>
