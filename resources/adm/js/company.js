// Submeter o fomrulário
$('body').on('submit', '#company-adm', function(event) {
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
                $('#id').val(response.id);
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
                msgPopup('error','Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        }
    });
});