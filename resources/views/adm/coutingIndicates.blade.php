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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Apuração (Indicações)</p>
            <div class="m-3 p-4 row bg-white">

                <ul id="container-list" name="container-list" class="list-group">
                    <li class="list-group-item list-group-item-success">
                        <div class="col-9 fw-bolder text-success">{{ $indication->title }}</div>
                    </li>

                    @if(@$cards->isEmpty() && @$search['src'] != '')

                        <li class="list-group-item">
                            <div class="col-7 fw-bolder pt-1">Não há registro(s) com o termo digitado (<b class="fw-bold">{{ @$search['src']; }}</b>).</div>
                            <div class="col-2 fw-bolder pt-1"></div>
                            <div class="container-actions col-3 fw-bolder text-end"></div>
                        </li>

                    @else

                        @if(@$cards->isEmpty())

                            <li class="list-group-item">
                                <div class="col-7 fw-bolder pt-1">Não há registro(s) cadastrado(s) no Sistema.</div>
                                <div class="col-2 fw-bolder pt-1"></div>
                                <div class="container-actions col-3 fw-bolder text-end"></div>
                            </li>

                        @else

                            @foreach($cards as $card)

                            <li id="line-<?=$card->id;?>" class="list-group-item">
                                <a href="#" class="flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                      <h5 class="mb-1 mt-1" style="font-size: 1em;"><b>{{ @$card->title }}</b> | <b>Total:</b> {{ $card->qtd_indicates + $card->qtd_candidates + $card->qtd_rejects }} inscrito(s)</h5>
                                      <small class="{{ $card->status_voting == 0 ? 'text-primary' : ($card->status_voting == 1 ? 'text-success' : ($card->status_voting == 2 ? 'text-danger' : 'text-muted')) }}" style="font-size: 0.8em;"><b>vaga(s):</b> {{ @$card->limit_indicates }} <b>|</b> <b>status:</b> {{ $card->status_voting == 0 ? 'aberta' : ($card->status_voting == 1 ? 'fechada' : ($card->status_voting == 2 ? 'empate' : 'indefinido')) }}
                                      </small>
                                    </div>
                                    <div class="btn-group btn-group-sm mt-1" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-primary btn-couting-indication" data-card="{{ $card->id }}" data-type="0" style="font-size: 0.75em;">{{ $card->qtd_indicates }} indicado(s)</button>
                                        <button type="button" class="btn btn-outline-success btn-couting-indication" data-card="{{ $card->id }}" data-type="1" style="font-size: 0.75em;">{{ $card->qtd_candidates }} candidato(s)</button>
                                        <button type="button" class="btn btn-outline-danger btn-couting-indication" data-card="{{ $card->id }}" data-type="3" style="font-size: 0.75em;">{{ $card->qtd_rejects }} indeferido(s)</button>
                                    </div>
                                  </a>
                            </li>

                            @endforeach

                        @endif

                    @endif

                </ul>

            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/indication.js') }}"></script>
</html>
