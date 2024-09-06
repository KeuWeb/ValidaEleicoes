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
            <p class="m-3 p-3 bg-success text-white"><a href="{{ url('/adm/cpanel') }}">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> <?php if(!empty(@$location->id)){?><a href="{{ route('adm.users') }}" target="_self">Editar/Excluir Localidades</a> <i class="bi bi-caret-right-fill text-white"></i> Editar Localidade - ({{ @$localidade->local }})<?php }else{ ?>Cadastrar Localidade<?php } ?></p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá cadastrar uma nova localidade, sendo:</p>
                <form id="user-adm" name="user-adm" autocomplete="off" method="PUT">
                @csrf
                @method('PUT')

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="local" name="local" placeholder="Localidade" value="{{ @$location->local }}" required>
                                <label for="user">Localidade*</label>
                            </div>
                        </div>

                        <div class="col-6">
                            <select id="category" name="category" class="form-select form-select-lg" required>
                                <option value="0" selected>Categoria a vincular</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="id" name="id" value="{{ @$location->id }}">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.user.do') }}">
                        <input id="salvar" name="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script src="{{ url(mix('inc/file/js/global.js')) }}"></script>
    <script src="{{ url(mix('inc/file/js/adm.js')) }}"></script>
</html>