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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Comunicação</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá efetuar toda comunicação com os Eleitores que o Sistema disponibiliza, <b class="fst-italic text-danger">somente usuários autorizados</b>, sendo:</p>
                <form id="communication-adm" name="communication-adm" class="row" autocomplete="off">
                @csrf
                @method('PUT')
                    <h5 class="mt-3"><b>Via WhatsApp</b></h5>

                    <p class="fs-6">Insira o número comercial e texto para comunicação em tempo real.</p>

                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control mask" data-ref="whatsapp" id="whatsapp" name="whatsapp" placeholder="somente números" value="{{ @$com_whatsapp }}">
                            <label for="whatsapp">Número <small class="fst-italic">(somente números)</small></label>
                        </div>
                    </div>

                    <div class="col-9">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="txt_whatsapp" name="txt_whatsapp" placeholder="breve texto" value="{{ @$com_txt_whatsapp }}">
                            <label for="txt_whatsapp">Texto de boas-vindas</label>
                        </div>
                    </div>

                    <h5 class="mt-4"><b>Via Sistema</b></h5>

                    <p class="fs-6">Efetue a comunicação interna, sendo as disponíveis:</p>

                    <div class="col-6">
                        <label for="txt_welcome" class="form-label">Texto de boas-vindas <small class="fst-italic">(tela inicial login)*</small></label>
                        <textarea class="form-control" id="txt_welcome" name="txt_welcome" rows="4" required>{{ @$com_first }}</textarea>
                    </div>

                    <div class="col-6">
                        <label for="txt_finish" class="form-label">Texto de voto computado <small class="fst-italic">(mensagem em tela final)</small></label>
                        <textarea class="form-control" id="txt_finish" name="txt_finish" rows="4" required>{{ @$com_end }}</textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <label for="txt_message" class="form-label">Texto do e-mail com dados do voto computado</label>
                        <textarea class="form-control" id="txt_message" name="txt_message" rows="4" required>{{ @$com_message }}</textarea>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.communication.do') }}">
                        <input id="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/communication.js') }}"></script>
</html>
