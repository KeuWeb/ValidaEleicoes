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
                <form id="form-delete" name="form-delete" class="btns-delete d-none">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" id="route-delete" name="route-delete" value="{{ route('adm.del.coutingList.do') }}"> --}}
                    <input type="hidden" id="idDelete" name="idDelete">
                    <button type="button" class="n-coutingList btn btn-success btn-sm">Cancelar</button>
                    <button type="submit" class="y-coutingList btn btn-danger btn-sm">Excluir</button>
                </form>
                <div class="time-bar bar" data-style="smooth"></div>
            </div>
        </div>
        <div id="container-system-adm">
            @include('adm/header')
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> <a href="{{ route('adm.couting.indicates') }}" target="_self">Apuração (Indicações)</a> <i class="bi bi-caret-right-fill text-white"></i> Lista de {{ $type == 0 ? "indicados" : ($type == 1 ? "candidatos" : ($type == 3 ? "indeferidos" : "")) }} - cédula {{ @$cards->title }}</p>
            <div class="m-3 p-4 row bg-white">
                <input type="hidden" name="limit_indicates" id="limit_indicates" value="{{ @$cards->limit_indicates }}">
                <input type="hidden" name="card" id="card" value="{{ @$cards->id }}">
                <form id="form-search" name="form-search" autocomplete="off" method="GET" style="padding-left: 0;">

                    <div class="input-group mb-3">
                        <input type="text" id="src" name="src" class="form-control" data-module="coutingList" placeholder="Digite o nome do inscrito a ser buscado">
                        <div class="input-group-append">
                        <button id="btn-search" name="btn-search" class="btn btn-success text-white" type="button"><i class="text-white bi bi-search"> buscar</i></button>
                        </div>
                    </div>

                </form>

                <ul id="container-list" name="container-list" class="list-group">
                    <li class="list-group-item list-group-item-success">
                        <div class="col-7 fw-bolder text-success">Listagem</div>
                        <div class="col-2 fw-bolder text-success"></div>
                    </li>

                    @if(@$candidates->isEmpty() && @$search['src'] != '')

                        <li class="list-group-item">
                            <div class="col-7 fw-bolder pt-1">Não há registro(s) com o termo digitado (<b class="fw-bold">{{ @$search['src']; }}</b>).</div>
                            <div class="col-2 fw-bolder pt-1"></div>
                            <div class="container-actions col-3 fw-bolder text-end"></div>
                        </li>

                    @else

                        @if(@$candidates->isEmpty())

                            <li class="list-group-item">
                                <div class="col-7 fw-bolder pt-1">Não há registro(s) cadastrado(s) no Sistema.</div>
                                <div class="col-2 fw-bolder pt-1"></div>
                                <div class="container-actions col-3 fw-bolder text-end"></div>
                            </li>

                        @else

                            @foreach($candidates as $candidate)

                            <li id="line-" class="list-group-item">
                                <div class="flex-column align-items-start col-7 position-relative start-0">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mt-1" style="margin-bottom: 0; font-size: 1em;"><b>{{ @$candidate->name }}</b></h5>
                                    </div>
                                    <small style="font-size: 0.8em;"><b>Total:</b> {{ $candidate->votes_indication }} indicação(ões)</small>
                                    <p style="margin: 5px 0 0 0;font-size: 0.8em;font-style: italic;">{{ @$candidate->obs }}</p>
                                </div>
                                @if($candidate->type == 0)
                                <div class="container-actions dropdown" style="float: right !important;">
                                    <button type="button" class="btn btn-coutingList" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a id="defer" class="dropdown-item text-success" data-id="{{ $candidate->tbcandidates_id }}" href="#" style="font-size: 0.8em;">
                                                <i class="bi bi-check-lg text-success" style="margin: 3px 5px 0 0;"></i> Deferir
                                            </a>
                                        </li>
                                        <li>
                                            <a id="reject" class="dropdown-item text-danger" data-id="{{ $candidate->tbcandidates_id }}" style="font-size: 0.8em;" href="#">
                                                <i class="bi bi-x-lg text-danger" style="margin: 3px 5px 0 0;"></i> Indeferir
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                @endif
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
</html>
