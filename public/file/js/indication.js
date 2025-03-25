// Ação para o envio dos dados para tratamento do formulário de indicação (Booth)
$(document).on('click', '#btn-confirm-indication', function() {
    $.ajax({
        url: $('#route').val(),
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            idCandidate: $('#idCandidate').val(),
            card: $('#card').val(),
            name: $('#name').val(),
            obs: $('#obs').val()
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
// Ação para direcionar para a pagina de listagem dos inidicados e candidatos (Módulo Apuração > Inidicação)
$(document).on('click', '.btn-couting-indication', function(){
    let card = $(this).attr('data-card');
    let type = $(this).attr('data-type');

    window.location.href = "/adm/coutingListIndicates/" + card + "/" + type;
});
// Ação para deferir ou indeferir em caso de empate (Módulo Apuração > Indicação)
$(document).on('click', '#defer, #reject', function(){
    let id_indicate = $(this).attr('data-id');
    let type = $(this).attr('id');

    $.ajax({
        url: "/adm/coutingListIndicates/do",
        type: "PUT",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            idIndidate: id_indicate,
            type: type,
            limitIndicates: $('#limit_indicates').val(),
            card: $('#card').val()
        },
        dataType: "json",
        success: function(response) {
            msgPopup(response.status, response.message);

            if (response.status == "success") {
                setTimeout(function() {
                    window.location.reload();
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

