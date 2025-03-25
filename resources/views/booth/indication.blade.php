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
                        <h4 class="w-100 border text-center bg-success py-2 text-white" style="border">{{ strtoupper($card->title) }}</h4>
                        <p class="text-secondary mt-3" style="margin-bottom: 5px;"><b>Efetuar uma nova indicação</b></p>
                        <form id="" name="" class="row" autocomplete="off">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control indication-input" id="name" name="name" placeholder="Nome completo" required>
                                <label for="name" style="margin-left: 15px;">Nome completo*</label>
                            </div>
                            <div class="col-12">
                                <label for="obs" class="form-label">Motivo da indicação <small class="fst-italic">(informações, CV, links externos, etc.)</small></label>
                                <textarea class="form-control indication-input" id="obs" name="obs" rows="4" required></textarea>
                            </div>
                        </form>
                        @if ($listIndications)
                        <p class="text-secondary mt-4 mb-1" style="margin-bottom: 0;"><b>Escolher uma entre as indicações já feita</b></p>
                        <div class="list-group dynamic-list-group">
                            {!! $listIndications !!}
                        </div>
                        @endif
                        <input type="hidden" id="idCandidate" name="idCandidate" value="">
                        <input type="hidden" id="card" name="card" value="{{ session('card') }}">
                        <input type="hidden" id="route" name="route" value="{{ route('booth.indication.do') }}">
                        <button type="button" id="btn-confirm-indication" name="btn-confirm-indication" class="btn btn-success py-2 col-12 mt-3 fs-5" disabled>
                            CONFIRMA
                        </button>
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
    <script type="module" src="{{ asset('file/js/indication.js') }}"></script>
    <script type="module" src="{{ asset('file/js/stopwatch.js') }}"></script>
    <script>
        localStorage.setItem('sessionInitialTime', {{ session('time') }});

        var countdownTime = {{ session('time') }};
    </script>
</html>
