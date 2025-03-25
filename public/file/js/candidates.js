// Abilitar campo categoria para listagem respectiva
$(document).on('change', '#local_candidate', function() {

    if ($('#local_candidate option:selected').val() != '') {
        let route = $(this).attr('data-route-url');

        $.ajax({
            url: route,
            type: "put",
            data: {
                location: $('#local_candidate option:selected').val()
            },
            dataType: 'json',
            success: function(response) {

                if (response.status == "success") {
                    $('#category_candidate').html(response.html).removeAttr('disabled');
                } else {
                    $('#category_candidate').attr('disabled', 'disabled');
                }

                return false;
            },
            error: function() {

                msgPopup('error', 'Ops! Falha ao buscar a lista da(s) categoria(s)');

                return false;
            },
            statusCode: {
                500: function() {
                    msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
                }
            }
        });
    }
});
// Abilitar campo cédula para listagem respectiva
$(document).on('change', '#category_candidate', function() {

    if ($('#local_candidate option:selected').val() != '' && $('#category_candidate option:selected').val() != '') {
        let route = $(this).attr('data-route-url');

        $.ajax({
            url: route,
            type: "put",
            data: {
                location: $('#local_candidate option:selected').val(),
                category: $('#category_candidate option:selected').val()
            },
            dataType: 'json',
            success: function(response) {

                if (response.status == "success") {
                    $('#card_candidate').html(response.html).removeAttr('disabled');
                } else {
                    $('#card_candidate').attr('disabled', 'disabled');
                }

                if (response.status == "alert") {
                    msgPopup(response.status, response.html);
                }

                return false;
            },
            error: function() {

                msgPopup('error', 'Ops! Falha ao buscar a lista da(s) categoria(s)');

                return false;
            },
            statusCode: {
                500: function() {
                    msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
                }
            }
        });
    }
});
// Salvar ou editar dados
$('body').on('submit', '#candidate-adm', function(event) {
    event.preventDefault();

    $('#salvar').val('AGUARDE...').attr('disabled','disabled');

    $.ajax({
        url: $('#route').val(),
        type: "put",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {

            msgPopup(response.status, response.message);

            $('#salvar').val('SALVAR').removeAttr('disabled');

            if (response.status == "success") {
                if($('#id').val() == ""){
                    $('input[type=text], input[type=number], input[type=file], #id_photo, #id_upload_photo').val('');
                    $('#card_candidate, #local_candidate, #category_candidate').prop('selectedIndex', 0);
                    $('#card_candidate, #category_candidate').attr('disabled', 'disabled');
                    $('#txt-photo-progress-bar').html('não há arquivo inserido').removeClass('text-success').addClass('text-danger');
                }
            }

            return false;
        },
        error: function(response) {

            msgPopup(response.status, response.message);

            $('#salvar').val('SALVAR').removeAttr('disabled');

            return false;
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        }
    });
});
// Botão de impressão
$(document).on('click','#btn-print', function() {
    window.open('printElection','_blank');
});
