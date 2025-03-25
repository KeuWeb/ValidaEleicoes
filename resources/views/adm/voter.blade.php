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
            <p class="m-3 p-3 bg-success text-white"><a href="{{ url('/adm/cpanel') }}">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> <?php if(!empty(@$voter->id)){?><a href="{{ route('adm.voters') }}" target="_self">Editar/Excluir Eleitores</a> <i class="bi bi-caret-right-fill text-white"></i> Editar Eleitor - ({{ @$voter->fullname }})<?php }else{ ?>Cadastrar Eleitor<?php } ?></p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá cadastrar um novo Eleitor, sendo:</p>
                <form id="voter-adm" name="voter-adm" autocomplete="off" method="PUT">
                @csrf
                @method('PUT')
                    <h6 class="mt-3"><b>Dados primários</b></h6>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nome completo" value="{{ @$voter->fullname }}" required>
                                <label for="fullname">Nome completo*</label>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="email" name="email" placeholder="E-mail válido" value="{{ @$voter->email }}" required>
                                <label for="email">E-mail*</label>
                            </div>
                        </div>

                     </div>

                    <div class="row">

                    <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="other_login" name="other_login" placeholder="Matrícula" value="{{ @$voter->other_login }}">
                                <label for="other_doc">Matrícula (caso houver)</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control mask" data-ref="rg" id="rg" name="rg" placeholder="00.000.000-0" value="{{ @$voter->rg }}" required>
                                <label for="rg">RG <small class="fst-italic">(somente números)</small></label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control mask" data-ref="cpf" id="cpf" name="cpf" placeholder="000.000.000-00" value="{{ @$voter->cpf }}" required>
                                <label for="cpf">CPF <small class="fst-italic">(somente números)</small></label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="other_doc" name="other_doc" placeholder="Outro documento" value="{{ @$voter->other_doc }}" required>
                                <label for="other_doc">Outro documento (passaporte, etc)</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-4">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control password" id="password" name="password" placeholder="senha valida" value="" <?php if(empty(@$voter->id)){ ?>required <?php } ?>>
                                <label for="password">Senha<?php if(empty(@$voter->id)){ ?>*<?php } ?></label>
                            </div>
                            <div class="row position-relative">
                                <div class="col-12 position-absolute" style="top: -22px;">
                                    <div id="container-doc-progress-bar" class="progress" role="progressbar" aria-label="Success example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                        <div id="doc-progress-bar" class="progress-bar bg-success" style="transition: 0.5s;height: 5px;width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-4 form-floating">
                            <select id="local_voter" name="local_voter" data-route-url="{{ route('adm.categories.list.do') }}" class="form-select form-select-lg" required>
                                <option value="" selected>Selecione a localidade</option>
                                @if(isset($locations))
                                    @foreach($locations as $location)
                                        <option class="opt-{{ $location->id }}" value="{{ $location->id }}" @if(isset($voter) && ($voter->local == $location->id)) selected @endif>{{ $location->local }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="local_voter" class="select-label">Localidade*</label>
                        </div>

                        @if(!empty($configs->form_category) && $configs->form_category == 1)
                        <div class="col-4 form-floating">
                            <select id="category" name="category" class="form-select form-select-lg" required @if(!isset($voter)) disabled @endif>
                                <option value="" selected>Selecione a categoria</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option class="opt-{{ $category->id }}" value="{{ $category->id }}" @if(isset($voter) && ($voter->category == $category->id)) selected @endif>{{ $category->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="category" class="select-label">Categoria*</label>
                        </div>
                        @endif

                    </div>

                    <div class="mt-3 gap-2">
                        <input type="hidden" id="form_category" name="form_category" value="{{ $configs->form_category }}">
                        <input type="hidden" id="id" name="id" value="{{ @$voter->id }}">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.voter.do') }}">
                        <input id="salvar" name="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
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
