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
            <p class="m-3 p-3 bg-success text-white"><a href="{{ url('/adm/cpanel') }}">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> <?php if(!empty(@$candidate->id)){?><a href="{{ route('adm.candidates') }}" target="_self">Editar/Excluir Candidatos</a> <i class="bi bi-caret-right-fill text-white"></i> Editar Candidato - ({{ @$candidate->name }})<?php }else{ ?>Cadastrar Candidato<?php } ?></p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá cadastrar um novo Candidato, sendo:</p>

                <form id="upload-photo-adm" name="upload-photo-adm" class="row files p-0 m-0" data-form="photo" autocomplete="off" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h6 class="mt-3"><b>Dados primários</b></h6>
                    <div class="row p-0 m-0">
                        <div class="col-12">
                            <label for="upload-photo" class="form-label">Foto (somente arquivos de imagem: png, gif, jpg e jpeg)</label>
                            <input class="form-control" type="file" name="upload-photo" id="upload-photo" accept="image/*">
                            @if(@$photo)
                            <small id="txt-photo-progress-bar" class="mt-2 d-table fst-italic text-success">arquivo cadastrado, para acessar, <a href="../../storage/{{ @$photo->link }}" target="_blank"><b class="text-success">clique aqui</b></a>.</small>
                            @else
                            <small id="txt-photo-progress-bar" class="mt-2 d-table fst-italic text-danger">não há arquivo inserido.</small>
                            @endif
                        </div>

                        <div class="col-12">
                            <div id="container-photo-progress-bar" class="d-none progress col-6" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div id="photo-progress-bar" class="progress-bar bg-success" style="width: 0%"></div>
                            </div>
                        </div>

                        <div class="mt-3 gap-2">
                            <input type="hidden" id="upload" name="upload" value="photo">
                            <input type="hidden" id="id_upload_photo" name="id_upload_photo" value="{{ @$candidate->photo ? $candidate->photo : '' }}">
                            <input type="hidden" id="route-photo" name="route-photo" value="{{ route('adm.uploads.do') }}">
                        </div>
                    </div>
                </form>

                <form id="candidate-adm" name="candidate-adm" autocomplete="off" method="PUT">
                @csrf
                @method('PUT')

                    <div class="row mb-3">

                        <div class="col-3 form-floating">
                            <select id="local_candidate" name="local_candidate" data-route-url="{{ route('adm.categories.list.do') }}" class="form-select form-select-lg" required>
                                <option value="" selected>Selecione o local</option>
                                @if(isset($locations))
                                    @foreach($locations as $location)
                                        <option class="opt-{{ $location->id }}" value="{{ $location->id }}" @if(isset($candidate) && ($candidate->local == $location->id)) selected @endif>{{ $location->local }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="local_candidates" class="select-label">Localidade*</label>
                        </div>

                        @if(!empty($configs->form_category) && $configs->form_category == 1)
                        <div class="col-3 form-floating">
                            <select id="category_candidate" name="category_candidate" class="form-select form-select-lg" data-route-url="{{ route('adm.cards.list.do') }}" required @if(!isset($candidate)) disabled @endif>
                                <option value="0" selected>Selecione a categoria</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option class="opt-{{ $category->id }}" value="{{ $category->id }}" @if(isset($candidate) && ($candidate->category == $category->id)) selected @endif>{{ $category->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="category_candidate" class="select-label">Categoria*</label>
                        </div>
                        @endif

                        <div class="col-3 form-floating">
                            <select id="card_candidate" name="card_candidate" class="form-select form-select-lg" required @if(!isset($candidate)) disabled @endif>
                                <option value="" selected>Selecione a cédula</option>
                                @if(isset($cards))
                                    @foreach($cards as $card)
                                        <option class="opt-{{ $card->id }}" value="{{ $card->id }}" @if(isset($candidate) && ($candidate->card == $card->id)) selected @endif>{{ $card->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="card_candidate" class="select-label">Cédula*</label>
                        </div>

                        <div class="col-3 form-floating">
                            <select id="type_candidate" name="type_candidate" class="form-select form-select-lg" required>
                                <option value="" selected>Selecione a posição</option>
                                <option value="0" @if(isset($candidate)) @if($candidate->type == 0) selected @endif @endif>Indicado</option>
                                <option value="1" @if(isset($candidate)) @if($candidate->type == 1) selected @endif @endif>Candidato</option>
                                <option value="2" @if(isset($candidate)) @if($candidate->type == 2) selected @endif @endif>Eleito</option>
                            </select>
                            <label for="type_candidate" class="select-label">Posição*</label>
                        </div>

                     </div>

                     <div class="row">

                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="{{ @$candidate->name }}" required>
                                <label for="name">Nome*</label>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="curriculum" name="curriculum" placeholder="curriculum" value="{{ @$candidate->curriculum }}" required>
                                <label for="name">Link de informações (CV, Linkedin, etc)*</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="txt_message" class="form-label">Dados adicionais (informações, CV, links, etc)</label>
                            <textarea class="form-control" id="obs" name="obs" rows="4" required>{{ @$candidate->obs }}</textarea>
                        </div>

                     </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="form_category" name="form_category" value="{{ $configs->form_category }}">
                        <input type="hidden" id="id" name="id" value="{{ @$candidate->id }}">
                        <input type="hidden" id="id_photo" name="id_photo" value="{{ @$candidate->photo }}">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.candidate.do') }}">
                        <input id="salvar" name="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/candidates.js') }}"></script>
</html>
