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
                <form id="formuser-delete" name="formuser-delete" class="btns-delete d-none" data-type="user">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="route-user" name="route-user" value="{{ route('adm.del.user.do') }}">
                    <input type="hidden" id="iduser" name="iduser">
                    <button type="button" class="n-user btn btn-success btn-sm">Cancelar</button>
                    <button type="submit" class="y-user btn btn-danger btn-sm">Excluir</button>
                </form>
                <div class="time-bar bar" data-style="smooth"></div>
            </div>
        </div>
        <div id="container-system">
            @include('adm/header')
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Editar/Excluir Usuário</p>
            <div class="m-3 p-4 row bg-white">
     
                <form id="form-search" name="form-search" autocomplete="off" method="GET" style="padding-left: 0;">
                    
                    <div class="input-group mb-3">
                        <input type="text" id="src" name="src" class="form-control" placeholder="Digite o nome do usuário a ser buscado" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                        <button id="btn-search-user" name="btn-search-user" class="btn btn-success text-white" type="button"><i class="text-white bi bi-search"> buscar</i></button>
                        </div>
                    </div>
    
                </form>
    
                <ul id="container-list" name="container-list" class="list-group">
                    <li class="list-group-item list-group-item-success">
                        <div class="col-7 fw-bolder text-success">Listagem</div>
                        <div class="col-2 fw-bolder text-success">Nível</div>
                    </li>
    
                    @if(@$users->isEmpty())
    
                        <li class="list-group-item">
                            <div class="col-7 fw-bolder pt-1">Não há registro(s) com o termo digitado (<b class="fw-bold">{{ @$search['src']; }}</b>).</div>
                            <div class="col-2 fw-bolder pt-1"></div>
                            <div class="container-actions col-3 fw-bolder text-end"></div>
                        </li>
    
                    @else
                        
                        @if(@$users->isEmpty())
    
                            <li class="list-group-item">
                                <div class="col-7 fw-bolder pt-1">Não há registro(s) cadastrado(s) no Sistema.</div>
                                <div class="col-2 fw-bolder pt-1"></div>
                                <div class="container-actions col-3 fw-bolder text-end"></div>
                            </li>
                        @else
    
                            @foreach($users as $user)
    
                            <li id="line-<?=$user->id;?>" class="list-group-item">
                                <div class="col-7 fw-bolder pt-1">{{ @$user->name }}</div>
                                <div class="col-2 fw-bolder pt-1">@if($user->level == 1) Master @else Básico @endif </div>
                                <div class="container-actions col-3 fw-bolder text-end">
                                    <a type="button" href="{{ route('adm.edit.user',@$user->id) }}" target="_self" class="edit-user btn btn-primary btn-sm text-white"><i class="bi bi-pencil-fill pt-1 me-1 text-white"></i>Editar</a>
                                    <button type="submit" data-id={{ @$user->id }} data-type="user" class="del-user btn btn-danger btn-sm"><i class="bi bi-trash-fill pt-1 me-1 text-white"></i>Excluir</button>
                                </div>
                            </li>
    
                            @endforeach
    
                        @endif
    
                    @endif
    
                </ul>
    
            </div>
        </div>

    </body>
    <script src="{{ url(mix('inc/file/js/global.js')) }}"></script>
    <script src="{{ url(mix('inc/file/js/adm.js')) }}"></script>
</html>