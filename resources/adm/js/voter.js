// Abilitar campo categoria para listagem respectiva
$(document).on('change', '#local', function() {

    if ($('#local option:selected').val() != '') {
        var route = $(this).attr('data-route-url');

        $.ajax({
            url: route,
            type: "put",
            data: {
                location: $('#local option:selected').val()
            },
            dataType: 'json',
            success: function(response) {
    
                if (response.status == "success") {
                    $('#category').html(response.html).removeAttr('disabled');
                } else {
                    $('#category').attr('disabled', 'disabled');
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
$('body').on('submit', '#voter-adm', function(event) {
    event.preventDefault();

    $('#salvar').val('AGUARDE...').attr('disabled','disabled');

    $.ajax({
        url: $('#route').val(),
        type: "put",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            
            msgPopup(response.status, response.message);

            if (response.status == "success") {
                if($('#id').val() == ""){
                    $('input[type=text],input[type=email],input[type=password]').val('');
                    $('#level').val($("#level option:first").val());
                    $('#doc-progress-bar').css({
                        'width':"0%",
                        'background-color':"#E9ECEF"
                    });
                }

                $('#id').val($idVoter);
            }

            $('#salvar').val('SALVAR').removeAttr('disabled');

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