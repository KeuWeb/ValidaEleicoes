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
            <p class="m-3 p-3 bg-success text-white"><a href="{{ url('/adm/cpanel') }}">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> <?php if(!empty(@$user->id)){?><a href="{{ route('adm.users') }}" target="_self">Editar/Excluir Usuário</a> <i class="bi bi-caret-right-fill text-white"></i> Editar Usuário - ({{ @$user->name }})<?php }else{ ?>Cadastrar Usuário<?php } ?></p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá cadastrar um novo Úsuário, sendo:</p>
                <form id="user-adm" name="user-adm" autocomplete="off" method="PUT">
                @csrf
                @method('PUT')
                    <h6 class="mt-3"><b>Dados primários</b></h6>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nome completo" value="{{ @$user->name }}" required>
                                <label for="user">Nome completo*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control mask" data-ref="phone" id="phone" name="phone" placeholder="(00) 00000-0000" value="{{ @$user->phone }}" required>
                                <label for="phone">Telefone/Celular <small class="fst-italic">(somente números)</small></label>
                            </div>
                        </div>

                        <div class="col-3 form-floating">
                            <select id="level" name="level" class="form-select form-select-lg" required>
                                <option value="0" selected>Selecione o nível</option>
                                @if (session('level') == 1)
                                <option value="1" @if(@$user->level == 1) selected="selected" @endif>Nível master (acesso apuração)</option>
                                @endif
                                <option value="2" @if(@$user->level == 2) selected="selected" @endif>Nivel normal</option>
                            </select>
                            <label for="level" class="select-label">Nível de acesso*</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control mask" data-ref="email" id="email" name="email" placeholder="e-mail válido" value="{{ @$user->email }}" required>
                                <label for="phone">E-mail*</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="login" name="login" placeholder="login valido" value="{{ @$user->login }}" required>
                                <label for="login">Login*</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control password" id="password" name="password" placeholder="senha valida" value="" <?php if(empty(@$user->id)){ ?>required <?php } ?>>
                                <label for="password">Senha<?php if(empty(@$user->id)){ ?>*<?php } ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="row position-relative">
                        <div class="col-4 position-absolute end-0" style="top: -22px;">
                            <div id="container-doc-progress-bar" class="progress" role="progressbar" aria-label="Success example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                <div id="doc-progress-bar" class="progress-bar bg-success" style="transition: 0.5s;height: 5px;width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="id" name="id" value="{{ @$user->id }}">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.user.do') }}">
                        <input id="salvar" name="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/user.js') }}"></script>
</html>
