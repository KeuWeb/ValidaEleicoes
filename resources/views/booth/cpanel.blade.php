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

                        <p class="mb-4 text-center text-secondary">{{ $configs->com_first ? $configs->com_first : '' }}</p>
                        @if(session('card'))
                        <button type="button" id="btn-choose-election" name="btn-choose-election" data-type="{{ session('type') }}" data-card="{{ session('card') }}" class="btn btn-success col-12">
                            {{ $election->title ? $election->title : '' }}
                        </button>
                        @else
                        <small class="fst-italic text-danger" style="width: 100%;display: table;text-align: center;">*{{ $election->title ? $election->title : '' }} finalizada ou não ativa para o seu perfil.</small>
                        @endif
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
