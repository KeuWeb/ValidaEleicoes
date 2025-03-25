<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <div id="modal-info" class="animated fadeInDownBig py-4 px-4" data-status="off" style="width: 50%;left: 25%;">
            <div class="d-flex justify-content-center">
                <h4 class="w-100 text-center"><b>INFORMAÇÕES</b></h4>
                <a href="#" class="btn btn-danger btn-close-modal-info"><b class="text-white">X</b></a>
            </div>
            <ul id="container-info" class="row pt-3">

            </ul>
        </div>
        <div id="container-system-adm">
            @include('adm/header')
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Apuração (Eleitores)</p>
            <div class="m-3 p-4 row bg-white">

                <div class="position-relative mb-3">
                    <button id="btn-print" name="btn-print" data-type="voter" class="btn btn-secondary text-white position-relative end-0" type="button" style="float: right;"><i class="text-white bi bi-printer"> Imprimir</i></button>
                </div>

                <ul id="container-list" name="container-list" class="list-group">
                    <li class="list-group-item list-group-item-success">
                        <div class="col-7 fw-bolder text-success">Listagem</div>
                        <div class="col-2 fw-bolder text-success"></div>
                    </li>

                        @if(@$voters)

                            @foreach($voters as $voter)

                            <li id="line-<?=$voter->id;?>" class="list-group-item">
                                <div class="col-7 fw-bolder pt-1">{{ @$voter->fullname }}</div>
                                <div class="col-2 fw-bolder pt-1"></div>
                                <div class="container-actions col-3 fw-bolder text-end">
                                    <a type="button" href="#" target="_self" data-voter="{{ @$voter->id }}" class="info-voter btn btn-primary btn-sm text-white"><i class="bi bi-info-circle pt-1 me-1 text-white"></i>Informações</a>
                                </div>
                            </li>

                            @endforeach

                        @endif

                </ul>

            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/voter.js') }}"></script>
</html>
