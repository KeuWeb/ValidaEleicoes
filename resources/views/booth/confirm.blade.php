<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">

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
                        <h4 class="w-100 border text-center bg-success py-2 text-white" style="border">PARTICIPAÇÃO EFETIVADA COM SUCESSO</h4>
                        <p class="mb-1 mt-4 text-center text-secondary">{{ $configs->com_end ? $configs->com_end : '' }}</p>
                        <p class="mb-4 text-center text-secondary">Abaixo segue <b>código de validação</b> de sua participação na {{ $election->title ? $election->title : '' }}</p>
                        <div class="w-50 border bg-white text-center py-3 px-3 display-6" style="margin: 0 auto; border-width: 5px !important;">
                            <b style="font-weight: bold;">{{ $code ? $code : '-' }}</b>
                        </div>
                        <p class="mt-4 text-center text-secondary">*voce receberá um <b>e-mail</b> com a comprovação da participação e o <b>código gerado</b>.</p>
                        <button type="button" id="btn-finish" name="btn-finish" class="btn btn-success py-2 col-12 mt-3 fs-5">
                            FINALIZAR
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
    <script type="module" src="{{ asset('file/js/election.js') }}"></script>
    <script type="module" src="{{ asset('file/js/stopwatch.js') }}"></script>
    <script>
        localStorage.setItem('sessionInitialTime', {{ session('time') }});

        var countdownTime = {{ session('time') }};

        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.pushState(null, null, location.href);

            window.location.href = "{{ route('booth.logout') }}";
        };
    </script>
</html>
