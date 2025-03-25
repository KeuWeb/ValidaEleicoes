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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Importar Eleitores</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá efetuar o upload de arquivo com a lista de Eleitores da Eleição <b class="fst-italic text-danger">somente usuários autorizados</b>, sendo:</p>
                <form id="upload-list-adm" name="upload-list-adm" class="row files" data-form="list" autocomplete="off" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h5 class="mt-3"><b>Arquivo</b></h5>

                    <p class="fs-6">Upload do arquivo com a lista de Eleitores sendo somente as seguintes informações <b class="fst-italic text-danger">(respeitando a ordem listada abaixo no arquivo)</b>. Caso não tenha a informação, deixar a coluna/celula em branco:</p>
                    <p class="text fst-italic"><i class="bi bi-caret-right-fill">Nome completo;</i><br><i class="bi bi-caret-right-fill">RG;</i><br><i class="bi bi-caret-right-fill">CPF;</i><br><i class="bi bi-caret-right-fill">E-mail;</i><br><i class="bi bi-caret-right-fill">Outro documento (caso não tenha os acima e seja estrangeiro).</i></p>

                    <div class="col-6">
                        <label for="upload-list" class="form-label">Somente arquivos Excel (csv)</label>
                        <input class="form-control" type="file" name="upload-list" id="upload-list" accept=".csv">
                        @if(@$import)
                        <small id="txt-list-progress-bar" class="mt-2 d-table fst-italic text-success">arquivo cadastrado, para acessar, <a href="../{{ @$import->link }}" target="_blank"><b class="text-success">clique aqui</b></a>.</small>
                        @else
                        <small id="txt-list-progress-bar" class="mt-2 d-table fst-italic text-danger">não há arquivo inserido.</small>
                        @endif
                    </div>

                    <div class="col-12">
                        <div id="container-list-progress-bar" class="d-none progress col-6" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div id="list-progress-bar" class="progress-bar bg-success" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="upload" name="upload" value="list">
                        <input type="hidden" id="id_upload_list" name="id_upload_list" value="{{ @$import->id ? $import->id : '' }}">
                        <input type="hidden" id="route-list" name="route-list" value="{{ route('adm.uploads.do') }}">
                    </div>
                </form>

            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/voter.js') }}"></script>
</html>
