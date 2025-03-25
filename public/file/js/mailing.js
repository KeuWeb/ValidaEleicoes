// Submeter o fomrulário
$('body').on('submit', '#mailing-adm', function(event) {
    event.preventDefault();

    $('#salvar').val('EMVIANDO...').attr('disabled','disabled');

    $.ajax({
        url: $('#route').val(),
        type: "put",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            
            msgPopup(response.status, response.message);

            $('#salvar').val('ENVIAR').removeAttr('disabled');

            return false;
        },
        error: function(response) {

            msgPopup(response.status, response.message);

            $('#salvar').val('ENVIAR').removeAttr('disabled');

            return false;
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        }
    });
});