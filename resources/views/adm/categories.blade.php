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
                <form id="form-delete" name="form-delete" class="btns-delete d-none" data-type="category">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="route-delete" name="route-delete" value="{{ route('adm.del.category.do') }}">
                    <input type="hidden" id="idDelete" name="idDelete">
                    <button type="button" class="n-category btn btn-success btn-sm">Cancelar</button>
                    <button type="submit" class="y-category btn btn-danger btn-sm">Excluir</button>
                </form>
                <div class="time-bar bar" data-style="smooth"></div>
            </div>
        </div>
        <div id="container-system">
            @include('adm/header')
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Editar/Excluir Categorias</p>
            <div class="m-3 p-4 row bg-white">
     
                <form id="form-search" name="form-search" autocomplete="off" method="PUT" style="padding-left: 0;">
    
                    <div class="input-group mb-3">
                        <input type="text" id="src" name="src" class="form-control" placeholder="Digite o nome da categoria a ser buscada">
                        <div class="input-group-append">
                        <button id="btn-search" name="btn-search" class="btn btn-success text-white" type="button"><i class="text-white bi bi-search"> buscar</i></button>
                        </div>
                    </div>
    
                </form>
    
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">
                        <div class="col-10 fw-bolder text-success">Listagem</div>
                    </li>
    
                    @foreach($categories as $category)
    
                    <li class="list-group-item">
                        <div class="col-9 fw-bolder pt-1">{{ @$category->title }}</div>
                        <div class="container-actions col-3 fw-bolder text-end">
                            <a type="button" href="{{ route('adm.edit.category',@$category->id) }}" target="_self" class="edit-category btn btn-primary btn-sm text-white"><i class="bi bi-pencil-fill pt-1 me-1 text-white"></i>Editar</a>
                            <button type="submit" data-id={{ @$category->id }} data-type="category" class="delete btn btn-danger btn-sm"><i class="bi bi-trash-fill pt-1 me-1 text-white"></i>Excluir</button>
                        </div>
                    </li>
    
                    @endforeach
    
                </ul>
    
            </div>
        </div>

    </body>
    <script src="{{ url(mix('inc/file/js/global.js')) }}"></script>
    <script src="{{ url(mix('inc/file/js/adm.js')) }}"></script>
</html>