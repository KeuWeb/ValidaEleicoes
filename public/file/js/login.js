// Submeter o formulário de login
$('body').on('submit', '#login-adm, #login-booth', function(event) {
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
                    if (response.redirect == 1) {
                        window.location = "adm/cpanel";
                    } else if (response.redirect == 2) {
                        window.location = "booth/cpanel";
                    } else {
                        window.location = "error";
                    }
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
// Submeter o formulário de esqueci minha senha
$('body').on('submit', '#forgot-adm, #forgot-booth', function(event) {
    event.preventDefault();

    $('#btn-forgot').val('AGUARDE...').attr('disabled','disabled');

    let formModule = $(this).attr('name');
    let typeModule = formModule.split('-');

    $.ajax({
        url: $('#route').val(),
        type: "post",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status == "success") {
                setTimeout(function() {
                    window.location = "/" + typeModule[1];
                }, 3000);
            }

            $('#btn-forgot').val('ENVIAR').removeAttr('disabled');

            msgPopup(response.status, response.message);

            return false;
        },
        error: function(response) {

            msgPopup(response.status,response.message);

            $('#btn-forgot').val('ENVIAR').removeAttr('disabled');

            return false;
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Falha ao enviar, tente mais tarde.');
            }
        }
    });
});
// Submeter o formulário de recuperar minha senha
$('body').on('submit', '#reset-adm, #reset-booth', function(event) {
    event.preventDefault();

    $('#btn-reset').val('AGUARDE...').attr('disabled','disabled');

    let formModule = $(this).attr('name');
    let typeModule = formModule.split('-');

    $.ajax({
        url: $('#route').val(),
        type: "post",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status == "success") {
                setTimeout(function() {
                    window.location = "/" + typeModule[1];
                }, 3000);
            }

            $('#btn-reset').val('ENVIAR').removeAttr('disabled');

            msgPopup(response.status, response.message);

            return false;
        },
        error: function(response) {

            msgPopup(response.status,response.message);

            $('#btn-reset').val('ENVIAR').removeAttr('disabled');

            return false;
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Falha ao salvar, tente mais tarde.');
            }
        }
    });
});
