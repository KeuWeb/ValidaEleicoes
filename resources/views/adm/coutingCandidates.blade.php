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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Apuração (Eleição)</p>
            <div class="m-3 p-4 row bg-white">

                <div class="position-relative mb-3">
                    <button id="btn-print" name="btn-print" data-type="election" class="btn btn-secondary text-white position-relative end-0" type="button" style="float: right;"><i class="text-white bi bi-printer"> Imprimir</i></button>
                </div>

                <ul id="container-list" name="container-list" class="list-group">
                    <li class="list-group-item list-group-item-success">
                        <div class="col-9 fw-bolder text-success">{{ $election->title }}</div>
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
                                <li id="line-{{$card->id}}" class="list-group-item">
                                    <a href="#" class="flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between mb-2">
                                            <h5 class="mb-1 mt-1 col-12" style="font-size: 1.1em;">
                                                <b>{{ strtoupper($card->title) }}</b>
                                            </h5>
                                        </div>
                                        <ul class="list-candidates">
                                            @php $i = 1; @endphp
                                            @foreach($card->candidatesList as $candidate)
                                                @php
                                                    $totalVotes = $card->totalVotes ?: 1;
                                                    $percentage = ($candidate['votes'] / $totalVotes) * 100;
                                                @endphp
                                                <li>
                                                    <div class="col-12 text-start" style="font-size: 0.9em;">
                                                        {{ $i++ }}º {{ $candidate['name'] }}
                                                    </div>
                                                    <div class="progress col-3">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ round($percentage, 2) }}%;"
                                                            aria-valuenow="{{ round($percentage, 2) }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ round($percentage, 2) }}%
                                                        </div>
                                                    </div>
                                                    <small class="col-7 text-start" style="position: relative;top: -7px;margin-left: 7px;font-size: 0.8em;">
                                                        {{ $candidate['votes'] }} voto(s)
                                                    </small>
                                                </li>
                                            @endforeach
                                        </ul>
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
    <script type="module" src="{{ asset('file/js/candidates.js') }}"></script>
</html>
