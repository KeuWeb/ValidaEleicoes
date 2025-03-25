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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Uploads</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá efetuar o(s) upload(s) de arquivos pertinentes a Eleição <b class="fst-italic text-danger">somente usuários autorizados</b>, sendo:</p>
                <form id="upload-logo-adm" name="upload-logo-adm" class="row files" data-form="logo" autocomplete="off" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h5 class="mt-3"><b>Logo</b></h5>

                    <p class="fs-6">Inclusão do logo para relatórios, e-mails, formalização de apuração, etc.</p>

                    <div class="col-6">
                        <label for="upload-logo" class="form-label">Somente arquivos de imagem (png, gif, jpg e jpeg)</label>
                        <input class="form-control" type="file" name="upload-logo" id="upload-logo" accept="image/*">
                        @if(@$logo)
                        <small id="txt-logo-progress-bar" class="mt-2 d-table fst-italic text-success">arquivo cadastrado, para acessar, <a href="../{{ @$logo->link }}" target="_blank"><b class="text-success">clique aqui</b></a>.</small>
                        @else
                        <small id="txt-logo-progress-bar" class="mt-2 d-table fst-italic text-danger">não há arquivo inserido.</small>
                        @endif
                    </div>

                    <div class="col-12">
                        <div id="container-logo-progress-bar" class="d-none progress col-6" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div id="logo-progress-bar" class="progress-bar bg-success" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="upload" name="upload" value="logo">
                        <input type="hidden" id="id_upload_logo" name="id_upload_logo" value="{{ @$logo ? $logo->id : '' }}">
                        <input type="hidden" id="route-logo" name="route-logo" value="{{ route('adm.uploads.do') }}">
                    </div>
                </form>

                <form id="upload-doc-adm" name="upload-doc-adm" class="row files" data-form="doc" autocomplete="off" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h5><b>Arquivos de texto</b></h5>

                    <p class="fs-6">Inclusão de arquivos de texto como Atas, comunicações, etc.</p>

                    <div class="col-6">
                        <label for="upload-doc" class="form-label">Somente arquivos de texto (doc, docx e pdf)</label>
                        <input class="form-control" type="file" name="upload-doc" id="upload-doc" accept="application/pdf, txt/*">
                        @if(@$doc)
                        <small id="txt-doc-progress-bar" class="mt-2 d-table fst-italic text-success">arquivo cadastrado, para acessar, <a href="../{{ @$doc->link }}" target="_blank"><b class="text-success">clique aqui</b></a>.</small>
                    @else
                        <small id="txt-doc-progress-bar" class="mt-2 d-table fst-italic text-danger">não há arquivo inserido.</small>
                    @endif
                    </div>

                    <div class="col-12">
                        <div id="container-doc-progress-bar" class="d-none progress col-6" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div id="doc-progress-bar" class="progress-bar bg-success" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="upload" name="upload" value="doc">
                        <input type="hidden" id="id_upload_doc" name="id_upload_doc" value="{{ @$doc ? $doc->id : '' }}">
                        <input type="hidden" id="route-doc" name="route-doc" value="{{ route('adm.uploads.do') }}">
                    </div>
                </form>

            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/uploads.js') }}"></script>
</html>
