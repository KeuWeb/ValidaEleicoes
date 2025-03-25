// const { on } = require("npm");

// Submeter o formulário
$('body').on('submit', '#ele-adm', function(event) {
    event.preventDefault();

    $.ajax({
        url: $('#route').val(),
        type: "put",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {

            msgPopup(response.status, response.message);

            $('#idIndication').val(response.idInd);
            $('#idElection').val(response.idEle);

            return false;
        },
        error: function(response) {

            msgPopup(response.status, response.message);

            return false;
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        }
    });
});
// Submeter o formulário para próximos passos da Eleição (modulo Eleitor - CPanel)
$(document).on('click', '#btn-choose-election', function() {
    let type = $(this).attr('data-type');
    let card = $(this).attr('data-card');

    if (type == 0) {
        window.location = "/booth/indication/" + card;
    } else if (type == 1) {
        window.location = "/booth/election/" + card;
    } else {
        msgPopup('alert', 'Ops! Acesso não liberado, entrar em contato com o Administrador');
    }

    return false;
});
// Logoff (finalização) da indicação e/ou eleição por parte do eleitor
$(document).on('click','#btn-finish', function() {
    window.location = "/booth/logout";
});
// Interação do botão de seleção de candidato na cédula de eleição (Módulo eleição > Eleitores)
$(document).on('click', '.check-votation, .btn-votation', function(){
    let dataType = $(this).attr('data-type');
    let stSelect = $(this).attr('data-status');
    let idSelect = $(this).attr('id');
    let qtdeCandidates = $('#qtde-candidates').val();
    let idsCandidates = $('#btnCandidates').val();


    if (dataType == "button") {
        $('#btnCandidates').val('');

        if (idSelect == "btn-null") {
            $('#btnNull').val(1);
            $('#btnWhite').val(0);
            $('#btn-white').attr('disabled', 'disabled');

        } else if (idSelect == "btn-white") {
            $('#btnWhite').val(1);
            $('#btnNull').val(0);
            $('#btn-null').attr('disabled', 'disabled');
        }

        $('.check-votation').css({
            'display': 'none'
        });

        $('#btn-confirm-election').removeAttr('disabled');

        return false;
    }

    if (dataType == 'list') {

        if (stSelect == 'off') {
            $(this).css({
                'background-image':"url(/file/img/icon-animated-on.gif?v=" + Math.random() + ")"
            });

            if (idsCandidates.indexOf(idSelect) === -1) {
                idsCandidates += (idsCandidates ? ',' : '') + idSelect;
            }

            $('#' + idSelect).attr('data-status', "on");
            $('#btnCandidates').val(idsCandidates);
            $('#btn-null, #btn-white').attr('disabled', 'disabled');
            $('#btnNull').val(0);
            $('#btnWhite').val(0);

            let qtdeSelects = idsCandidates ? idsCandidates.split(',').length : 0;

            if (qtdeCandidates == qtdeSelects) {
                $('#btn-confirm-election').removeAttr('disabled');
                $('.check-votation').css({
                    'display': 'none'
                });
                $('#' + idSelect).css({
                    'display': 'block'
                });
            } else {
                $('#btn-confirm-election').attr('disabled', true);
                $('#btn-null, #btn-white').attr('disabled', false);
                $('.check-votation').css({
                    'display': 'block'
                });
            }

            return false;
        }

        if (stSelect == 'on') {
            $(this).css({
                'background-image':"url(/file/img/icon-animated-off.gif?v=" + Math.random() + ")"
            });

            let idsArray = idsCandidates.split(',');

            idsArray = idsArray.filter(id => id !== idSelect);
            let upIdsCandidates = idsArray.join(',')

            $('#btnCandidates').val(upIdsCandidates);
            $('#' + idSelect).attr('data-status', "off");
            $('#btn-null, #btn-white').attr('disabled', 'disabled');
            $('#btnNull').val(0);
            $('#btnWhite').val(0);

            let qtdeSelects = upIdsCandidates ? upIdsCandidates.split(',').length : 0;

            console.log(qtdeSelects);

            if (qtdeSelects == qtdeCandidates) {
                $('#btn-confirm-election').removeAttr('disabled');
                $('.check-votation').css({
                    'display': 'none'
                });
                $('#' + idSelect).css({
                    'display': 'block'
                });
            } else {
                $('#btn-confirm-election').attr('disabled', true);
                $('#btn-null, #btn-white').attr('disabled', false);
                $('.check-votation').css({
                    'display': 'block'
                });
            }

            return false;
        }
    }
});
// Ação para abertura da modal de informações (Booth > Eleição)
$(document).on('click', '.btn-modal-info', function (e) {
    e.preventDefault();

    let idCandidate = $(this).attr('data-candidate');

    $.ajax({
        url: "/booth/election/info",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            idCandidate: idCandidate
        },
        dataType: "json",
        success: function(response) {
            $('#container-system-booth-login').css({
                'filter':'blur(5px)'
            });

            setTimeout(function() {
                $('#modal-info').html(response.html).css({
                    'display':"block"
                }).removeClass('fadeOutUpBig').addClass('fadeInDownBig').attr('data-status',"on");
            }, 300);
        },
        error: function(xhr) {
            msgPopup(response.status, response.message);
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        }
    });
});
// Ação para fechar a modal de informações (Booth > Eleição)
$(document).on('click', '.btn-close-modal-info', function() {
    $('#modal-info').removeClass('fadeInDownBig').addClass('fadeOutUpBig').attr('data-status',"off");

    setTimeout(function() {
        $('#modal-info').css({
            'display':"none"
        }).html('');

        $('#container-system-booth-login').css({
            'filter':'none'
        });
    }, 500);
});
// Ação para o envio dos dados para tratamento do formulário de eleição (Booth > Eleição)
$(document).on('click', '#btn-confirm-election', function(e) {
    e.preventDefault();

    let selectedCandidates = $('#btnCandidates').val();

    $.ajax({
        url: $('#route').val(),
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            card: $('#card').val(),
            voteNull: $('#btnNull').val(),
            voteWhite: $('#btnWhite').val(),
            qtdeCandidates: $('#qtde-candidates').val(),
            idCandidates: selectedCandidates
        },
        dataType: "json",
        success: function(response) {
            msgPopup(response.status, response.message);

            if (response.status == "success") {
                setTimeout(function() {
                    window.location.href = response.route;
                }, 3000);
            }
        },
        error: function(xhr) {
            msgPopup(response.status, response.message);
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        }
    });
});

