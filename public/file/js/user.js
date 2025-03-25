// Salvar ou editar dados
$('body').on('submit', '#user-adm', function(event) {
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

                $('#id').val($idUser);
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