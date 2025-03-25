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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Mailing</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá efetuar a comunicação por disparo de mensagem(ns) por e-mail, para um ou mais contas de Eleitores, <b class="fst-italic text-danger">somente usuários autorizados</b>, sendo:</p>
                <form id="mailing-adm" name="mailing-adm" class="row" autocomplete="off">
                @csrf
                @method('PUT')

                    <div class="col-6 form-floating">
                        <select id="type" name="type" class="form-select form-select-lg">
                            <option value="0" selected>Selecione o tipo de Eleitor</option>
                            <option value="1">Todos os eleitores</option>
                            <option value="2">Eleitores que não votaram</option>
                            <option value="3">Eleitores que já votaram</option>
                        </select>
                        <label for="type" class="select-label">Tipo de Eleitor*</label>
                    </div>

                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="title" name="title" placeholder="titulo do e-mail" required>
                            <label for="title">Titulo do e-mail</small></label>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <label for="txt" class="form-label">Texto do e-mail</label>
                        <textarea class="form-control" id="txt" name="txt" rows="4" required></textarea>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.mailing.do') }}">
                        <input id="salvar" type="submit" value="ENVIAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/mailing.js') }}"></script>
</html>
