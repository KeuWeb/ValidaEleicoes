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
            <p class="m-3 p-3 bg-success text-white"><a href="{{ url('/adm/cpanel') }}">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> <?php if(!empty(@$card->id)){?><a href="{{ route('adm.cards') }}" target="_self">Editar/Excluir Cédulas</a> <i class="bi bi-caret-right-fill text-white"></i> Editar Cédula - ({{ @$card->title }})<?php }else{ ?>Cadastrar Cédula<?php } ?></p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá cadastrar uma nova Cédula, sendo:</p>
                <form id="card-adm" name="card-adm" autocomplete="off" method="PUT">
                @csrf
                @method('PUT')
                    <h6 class="mt-3"><b>Dados primários</b></h6>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Titulo" value="{{ @$card->title }}" required>
                                <label for="title">Titulo*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="order" name="order" placeholder="Ordem" value="{{ @$card->order }}" required>
                                <label for="order">Ordem*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="limit_votes" name="limit_votes" placeholder="Limite de votos" value="{{ $card->limit_votes ?? 1 }}" required>
                                <label for="limit_votes">Limite de votos</label>
                            </div>
                        </div>

                     </div>

                    <div class="row">

                        <div class="col-4 form-floating">
                            <select id="local_card" name="local_card" data-route-url="{{ route('adm.categories.list.do') }}" class="form-select form-select-lg" required>
                                <option value="" selected>Selecione o local</option>
                                @if(isset($locations))
                                    @foreach($locations as $location)
                                        <option class="opt-{{ $location->id }}" value="{{ $location->id }}" @if(isset($card) && ($card->local == $location->id)) selected @endif>{{ $location->local }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="local_card" class="select-label">Localidade*</label>
                        </div>

                        @if(!empty($configs->form_category) && $configs->form_category == 1)
                        <div class="col-4 form-floating">
                            <select id="category" name="category" class="form-select form-select-lg" required @if(!isset($card)) disabled @endif>
                                @if(isset($categories))
                                    <option value="">Selecione a categoria</option>
                                    @foreach($categories as $category)
                                        <option class="opt-{{ $category->id }}" value="{{ $category->id }}" @if(isset($card) && ($card->category == $category->id)) selected @endif>{{ $category->title }}</option>
                                    @endforeach
                                @else
                                    <option value="" selected>Selecione a categoria</option>
                                @endif
                            </select>
                            <label for="category" class="select-label">Categoria*</label>
                        </div>
                        @endif
                        @if($configs->type >= 3)
                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="limit_indicates" name="limit_indicates" placeholder="Limite de indicados" value="{{ @$card->limit_indicates }}" required>
                                <label for="limit_indicates">Limite de indicados</label>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="form_category" name="form_category" value="{{ $configs->form_category }}">
                        <input type="hidden" id="id" name="id" value="{{ @$card->id }}">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.card.do') }}">
                        <input id="salvar" name="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/card.js') }}"></script>
</html>
