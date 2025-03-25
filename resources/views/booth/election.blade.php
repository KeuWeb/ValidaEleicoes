<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Valida Eleições - Sistema de Eleições</title>
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <link rel="stylesheet" href="{{ asset('/file/css/global.css') }}">
    </head>
    <body style="background-color: #E6E7EB">
      <div class="d-flex justify-content-center">
        <div id="msg-popup" class="animated">
          <i></i>
          <span></span>
          <div class="time-bar bar" data-style="smooth"></div>
        </div>
      </div>
      <div id="modal-info" class="animated fadeInDownBig py-4 px-4" data-status="off">
        <div class="d-flex justify-content-center">
            <h4 class="w-100 text-center"><b>INFORMAÇÕES</b></h4>
            <a href="#" class="btn btn-danger"><b class="text-white">X</b></a>
        </div>
        <p class="pt-3 mx-0 px-0">Você tem <span id="time-remaining">dd</span> minuto(s) para votar.</p>
        <b class="">Link externo:</b> <a href="#" target="_blank" class="text-success">clique aqui</a>
    </div>
      <div id="container-system-booth-login">
        <div class="container">
          <div class="row justify-content-center align-items-center vh-100">
            <div class="col-1"></div>

            <div class="col-10">
                <div class="row">
                    <div class="col-12 p-4 bg-body border border-2 mb-1" style="--bs-bg-opacity: 0.7;">
                        <div class="row">

                            <div class="col-10">
                                <div class="col-12">
                                    <p class="mx-0 my-0 px-0 py-0"><b class="text-success">Eleitor(a): </b>{{ session('name') }}</p>
                                    <p class="mx-0 my-0 px-0 py-0"><b class="text-success">Documento: </b>{{ session('doc') }}</p>
                                    <p class="mx-0 my-0 px-0 py-0"><b class="text-success">Tempo: </b><span id="timer"></span></p>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="col-12">
                                    <img src="{{ url('/') . '/' . session('logo') }}" alt="" height="70" class="d-inline-block align-text-top position-relative" style="float: right !important;">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-12 p-4 bg-body border border-2" style="--bs-bg-opacity: 0.7;">
                        <h4 class="w-100 border text-center bg-success py-2 text-white">{{ strtoupper($card->title) }}</h4>
                        <form id="" name="" class="w-100" autocomplete="off">
                            @csrf

                            @foreach($candidates as $candidate)
                            <ul class="d-flex bg-white w-100" style="padding: 20px;">
                                <li class="border border-dark border-3" style="width: 110px;height: 130px;">
                                    <img src="{{ $candidate->photoUpload ? asset('storage/' . $candidate->photoUpload->link) : asset('storage/photo/icon-avatar.gif') }}"
                                         alt="{{ $candidate->name }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </li>
                                <li class="col-8 ms-3">
                                    <small class="text-success">candidato(a)</small>
                                    <p>{{ $candidate->name }}</p>
                                    <small class="d-block" style="margin-top: 60px;font-style: italic !important;">
                                        <a href="#" data-candidate="{{ $candidate->id }}" class="text-success btn-modal-info" style="font-style: italic !important;">clique aqui</em></a> para maiores informações
                                    </small>
                                </li>
                                <li class="col-2 position-relative end-0">
                                    <div id="{{ $candidate->id }}" data-type="list" name="{{ $candidate->id }}" class="check-votation" data-status="off">
                                    </div>
                                </li>
                            </ul>
                        @endforeach

                        <input type="hidden" id="card" name="card" value="{{ session('card') }}">
                        <input type="hidden" id="qtde-candidates" name="qtde-candidates" value="{{ $card->limit_votes }}">
                        <input type="hidden" id="route" name="route" value="{{ route('booth.election.do') }}">
                        <input type="hidden" id="btnNull" name="btnNull" value="0">
                        <input type="hidden" id="btnWhite" name="btnWhite" value="0">
                        <input type="hidden" id="btnCandidates" name="btnCandidates" value="">
                        <div class="d-flex justify-content-between">
                            <button type="button" name="btn-null" id="btn-null" data-type="button" class="btn-votation btn btn-danger w-50 me-2 fs-5 py-2">
                                NULO
                            </button>
                            <button type="button" name="btn-white" id="btn-white" data-type="button" class="btn-votation btn btn-light border w-50 fs-5 py-2 ms-auto">
                                BRANCO
                            </button>
                        </div>
                        <button type="submit" id="btn-confirm-election" name="btn-confirm-election" class="btn btn-success py-2 col-12 mt-2 fs-5" disabled="disabled">
                            CONFIRMA
                        </button>

                        </form>
                    </div>


                </div>
            </div>

            <div class="col-1"></div>
          </div>
        </div>
      </div>
      <span id="link-copyright">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/election.js') }}"></script>
    <script type="module" src="{{ asset('file/js/stopwatch.js') }}"></script>
    <script>
        localStorage.setItem('sessionInitialTime', {{ session('time') }});

        var countdownTime = {{ session('time') }};
    </script>
</html>
