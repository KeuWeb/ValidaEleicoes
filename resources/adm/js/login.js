// Submeter o fomrulário
$('body').on('submit', '#login-adm', function(event) {
    event.preventDefault();

    $('#btn-login').val('AGUARDE...').attr('disabled','disabled');

    $.ajax({
        url: $('#route').val(),
        type: "post",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status == "success") {
                setTimeout(function() {
                    window.location = "adm/cpanel";
                }, 3000);
            }

            $('#btn-login').val('EFETUAR LOGIN').removeAttr('disabled');

            msgPopup(response.status, response.message);

            return false;
        },
        error: function(response) {

            msgPopup(response.status,response.message);

            $('#btn-login').val('EFETUAR LOGIN').removeAttr('disabled');

            return false;
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Erro ao efetuar o login, tente mais tarde.');
            }
        }
    });
});