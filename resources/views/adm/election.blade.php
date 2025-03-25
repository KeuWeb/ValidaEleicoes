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
            <p class="m-3 p-3 bg-success text-white"><a href="cpanel">CPanel</a> <i class="bi bi-caret-right-fill text-white"></i> Gerenciador da Eleição</p>
            <div class="m-3 px-2 pt-3 py-2 row bg-white">
                <p>Aqui você poderá cadastrar, editar ou excluir a Indicação/Eleição, <b class="text-danger">somente usuários autorizados</b>, sendo:</p>
                <form id="ele-adm" name="ele-adm" autocomplete="off">
                @csrf
                @method('PUT')

                @if(empty(!@$type) && @$type->type >= 3)

                    <h6 class="mt-3"><b>Dados da Indicação</b></h6>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="titleInd" name="titleInd" @if(!empty($indication)) value="{{ $indication->title }}" @endif placeholder="Titulo" required>
                                <label for="titleInd">Título*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="dateIniInd" name="dateIniInd" @if(!empty($indication)) value="{{ date('Y-m-d',strtotime($indication->date_initial)) }}" @endif required>
                                <label for="dateIniInd">Data inicial <small class="fst-italic">(indicação)</small>*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="hourIniInd" name="hourIniInd" @if(!empty($indication)) value="{{ $indication->hour_initial }}" @endif required>
                                <label for="hourIniInd">Hora data inicial <small class="fst-italic">(indicação)</small>*</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="dateEndInd" name="dateEndInd" @if(!empty($indication)) value="{{ date('Y-m-d',strtotime($indication->date_end)) }}" @endif required>
                                <label for="dateEndInd">Data final <small class="fst-italic">(indicação)</small>*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="hourEndInd" name="hourEndInd" @if(!empty($indication)) value="{{ $indication->hour_end }}" @endif required>
                                <label for="hourEndInd">Hora data final <small class="fst-italic">(indicação)</small>*</label>
                            </div>
                        </div>

                        @if ($type->form_aval == 2)

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="dateInvInd" name="dateInvInd" @if(!empty($indication)) value="{{ date('Y-m-d',strtotime($indication->date_invite)) }}" @endif required>
                                <label for="dateInvInd">Data apuração <small class="fst-italic">(indicação)</small>*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="hourInvInd" name="hourInvInd" @if(!empty($indication)) value="{{ date('H:i',strtotime($indication->hour_invite)) }}" @endif required>
                                <label for="hourInvInd">Hora data apuração <small class="fst-italic">(indicação)</small>*</label>
                            </div>
                        </div>

                        @endif

                        <input type="hidden" name="indication" id="indication" value="0">
                        <input type="hidden" name="idIndication" id="idIndication" @if(!empty($indication)) value="{{ $indication->id }}" @endif>

                    </div>

                @endif

                    <h6 class="mt-3"><b>Dados da Eleição</b></h6>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="titleEle" name="titleEle" placeholder="Titulo" @if(!empty($election)) value="{{ $election->title }}" @endif required>
                                <label for="titleEle">Título*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="dateIniEle" name="dateIniEle" @if(!empty($election)) value="{{ date('Y-m-d',strtotime($election->date_initial)) }}" @endif required>
                                <label for="dateIniEle">Data inicial <small class="fst-italic">(eleição)</small>*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="hourIniEle" name="hourIniEle" @if(!empty($election)) value="{{ date('H:i',strtotime($election->hour_initial)) }}" @endif required>
                                <label for="hourIniEle">Hora data inicial <small class="fst-italic">(eleição)</small>*</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="dateEndEle" name="dateEndEle" @if(!empty($election)) value="{{ date('Y-m-d',strtotime($election->date_end)) }}" @endif required>
                                <label for="dateEndEle">Data final <small class="fst-italic">(eleição)</small>*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="hourEndEle" name="hourEndEle" @if(!empty($election)) value="{{ date('H:i',strtotime($election->hour_end)) }}" @endif required>
                                <label for="hourEndEle">Hora data final <small class="fst-italic">(eleição)</small>*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="dateInvEle" name="dateInvEle" @if(!empty($election)) value="{{ date('Y-m-d',strtotime($election->date_invite)) }}" @endif required>
                                <label for="dateInvEle">Data apuração <small class="fst-italic">(eleição)</small>*</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="hourInvEle" name="hourInvEle" @if(!empty($election)) value="{{ date('H:i',strtotime($election->hour_invite)) }}" @endif required>
                                <label for="hourInvEle">Hora data apuração <small class="fst-italic">(eleição)</small>*</label>
                            </div>
                        </div>
                        <input type="hidden" name="idElection" id="idElection" @if(!empty($election)) value="{{ $election->id }}" @endif>
                    </div>
                    <div class="mt-3 gap-2">
                        <input type="hidden" name="election" id="election" value="1">
                        <input type="hidden" id="route" name="route" value="{{ route('adm.election.do') }}">
                        <input id="salvar" type="submit" value="SALVAR" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <span id="link-copyright" style="color: gray;">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/election.js') }}"></script>
</html>
