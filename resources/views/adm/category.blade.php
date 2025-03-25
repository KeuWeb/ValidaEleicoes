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
            <p class="m-3 p-3 bg-success text-white"><a href="{{ url('/adm/cpanel') }}">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> <?php if(!empty(@$category->id)){?><a href="{{ route('adm.categories') }}" target="_self">Editar/Excluir Categoria</a> <i class="bi bi-caret-right-fill text-white"></i> Editar Categoria - ({{ @$category->title }})<?php }else{ ?>Cadastrar Categoria<?php } ?></p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá cadastrar uma nova Categoria, sendo:</p>
                <form id="category-adm" name="category-adm" autocomplete="off" method="PUT">
                @csrf
                @method('PUT')
                    {{-- <h6 class="mt-3"><b>Dados primários</b></h6> --}}

                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Completo" value="{{ @$category->title }}" required>
                                <label for="user">Titulo*</label>
                              </div>
                        </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="id" name="id" value="{{ @$category->id }}">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.category.do') }}">
                        <input id="salvar" name="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/category.js') }}"></script>
</html>
