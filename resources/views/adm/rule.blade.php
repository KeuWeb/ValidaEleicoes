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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Regras de Eleição</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá determinar as regras da Eleição oferecidas pelo Sistema, <b class="fst-italic text-danger">somente usuários autorizados</b>, sendo:</p>
                <form id="rule-adm" name="rule-adm" autocomplete="off">
                @csrf
                @method('PUT')
                    <h5 class="mt-3"><b>Acesso a Votação</b></h5>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="access" id="access1" value="1" @if (empty(!@$access) && @$access == 1) checked @endif>
                            <label class="form-check-label" for="access1">
                                <b class="fw-bold text-dark">Por CPF (padrão)</b>
                            </label>
                            <p class="fs-6">Essa opção formaliza o acesso do eleitor a cabine de votação por login tipo CPF.</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="access" id="access2" value="2" @if(empty(!@$access) && @$access == 2) checked @endif>
                            <label class="form-check-label" for="access2">
                                <b class="fw-bold text-dark">Por E-mail</b>
                            </label>
                            <p class="fs-6">Essa opção formaliza o acesso do eleitor a cabine de votação por e-mail.</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="access" id="access3" value="3" @if(empty(!@$access) && @$access == 3) checked @endif>
                            <label class="form-check-label" for="access3">
                                <b class="fw-bold text-dark">Personalizado</b>
                            </label>
                            <p class="fs-6">Essa opção formaliza o acesso do eleitor a cabine de votação por login personalizado (Matricula).</p>
                        </div>
                    </div>

                    <h5 class="mt-4"><b>Eleitores</b></h5>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="2" id="foreigner" name="foreigner" @if(empty(!@$foreigner) && @$foreigner == 2) checked @endif>
                        <label class="form-check-label" for="foreigner">
                            <b class="fw-bold text-dark">Possui eleitor(es) estrangeiro(s)</b>
                        </label>
                        <p class="fs-6">Essa opção ativa a opção de cadastro de estrangeiro como eleitor, podendo ter acesso a cabine de votação por meio do passaporte, caso não tenha documento oficial nacional permitido no sistema.</p>
                    </div>

                    <h5 class="mt-4"><b>Regras adversas</b></h5>

                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control mask" data-ref="time" id="time" name="time" placeholder="Tempo em segundos" value="{{ @$time }}" required>
                            <label for="title">Tempo da cabine aberta <small class="fst-italic">(em segundos)</small>*</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control mask" data-ref="difvotes" id="difvotes" name="difvotes" placeholder="Em porcentagem" value="{{ @$difvotes }}" required>
                            <label for="title">Porcentagem de votos para o 2º turno*</label>
                        </div>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.rule.do') }}">
                        <input id="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/rule.js') }}"></script>
</html>
