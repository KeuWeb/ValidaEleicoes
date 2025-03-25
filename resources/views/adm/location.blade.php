<!DOCTYPE html>
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
            <p class="m-3 p-3 bg-success text-white"><a href="{{ url('/adm/cpanel') }}">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> <?php if(!empty(@$location->id)){?><a href="{{ route('adm.locations') }}" target="_self">Editar/Excluir Localidades</a> <i class="bi bi-caret-right-fill text-white"></i> Editar Localidade - ({{ @$location->local }})<?php }else{ ?>Cadastrar Localidade<?php } ?></p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white" style="padding-bottom: 1rem !important;">
                <p>Aqui você poderá cadastrar uma nova localidade, sendo:</p>
                <form id="location-adm" name="location-adm" autocomplete="off" method="PUT">
                @csrf
                @method('PUT')

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="local" name="local" placeholder="Localidade" value="{{ @$location->local }}" required>
                                <label for="local">Localidade*</label>
                            </div>
                        </div>

                        <div class="col-6 form-floating">
                            <select id="category" name="category" class="category form-select form-select-lg">
                                <option value="" selected>Selecione a categoria a vincular</option>
                                <option class="opt-0" value="0">Todas as categorias</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option @if (isset($catsLocations)) @if (in_array($category->id,$catsLocations)) disabled @endif @endif class="opt-{{ $category->id }}" value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="category" class="select-label">Categoria*</label>
                        </div>
                    </div>
                    <b>Categorias já selecionadas:</b>
                    <ul class="row container-locations">
                        @if(isset($catsLocation))
                        <li class="box-locations">
                            <ul class="list-locations">
                                @foreach($catsLocation as $catLocation)
                                    <li class="location-{{ $catLocation->id }}">
                                        <span class="dlt-cat" data-id="{{ $catLocation->id }}"><i class="bi bi-trash-fill pt-1 text-white"></i></span>
                                        <p>{{ $catLocation->title }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        @else
                            <li class="txt-locations">Não há categoria(s) selecionada(s) para a localidade.</li>
                                <li class="box-locations">
                                    <ul class="list-locations">

                                    </ul>
                            </li>
                        @endif
                    </ul>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="categories" name="categories" @if (isset($catsLocations)) value="{{ implode(',',$catsLocations) ?? null }}" @endif>
                        <input type="hidden" id="id" name="id" value="{{ @$location->id }}">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.location.do') }}">
                        <input id="salvar" name="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/location.js') }}"></script>
</html>
