<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Valida Eleições - Sistema de Eleições</title>
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <link rel="stylesheet" type="text/css" href="{{ url(mix('inc/file/css/global.css')) }}">
    </head>
    <body class="w-100" style="background-color: #EEE;">
        <div class="d-flex justify-content-center">
            <div id="msg-popup" class="animated">
                <i></i>
                <span></span>
                <div class="time-bar bar" data-style="smooth"></div>
            </div>
        </div>
        <div id="container-system">
            @include('adm/header')
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Gerenciador da Eleição</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá cadastrar, editar ou excluir a Indicação/Eleição, <b class="text-danger">somente usuários autorizados</b>, sendo:</p>
                <form id="ele-adm" name="ele-adm" autocomplete="off">
                @csrf
                @method('PUT')

                    <h6 class="mt-3"><b>Dados da Eleição</b></h6>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Titulo" required>
                                <label for="title">Título*</label>
                            </div>                       
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="date-str-ele" name="date-str-ele" required>
                                <label for="date-str-ele">Data inicial <small class="fst-italic">(eleição)</small>*</label>
                            </div>                       
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="date-end-ele" name="date-end-ele" required>
                                <label for="date-end-ele">Data final <small class="fst-italic">(eleição)</small>*</label>
                            </div>                       
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="date-inv-ele" name="date-inv-ele" required>
                                <label for="date-inv-ele">Data apuração <small class="fst-italic">(eleição)</small>*</label>
                            </div>                       
                        </div>

                        @if(empty(!@$type) && @$type >= 3)

                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="date-str-ind" name="date-str-ind" required>
                                <label for="date-str-ind">Data inicial <small class="fst-italic">(indicação)</small>*</label>
                            </div>                       
                        </div>

                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="date-end-ind" name="date-end-ind" required>
                                <label for="date-end-ind">Data final <small class="fst-italic">(indicação)</small>*</label>
                            </div>                       
                        </div>

                        @endif
                        
                    </div>
                    <div class="mt-3 gap-2">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.election.do') }}">
                        <input id="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script src="{{ url(mix('inc/file/js/global.js')) }}"></script>
    <script src="{{ url(mix('inc/file/js/adm.js')) }}"></script>
</html>