$(document).ready(function() {
    // Validador de item clicado/selecionado (list group)
    $(document).on('click', '.dynamic-list', function() {
        let button = $(this).attr('data-button');

        $('.dynamic-list-group a').removeClass('btn-list-active');
        $('.indication-input').val('').html('');

        $('.btn-list' + button).addClass('btn-list-active');

        $('#idCandidate').val(button);

        if ($('#idCandidate').val() != '') {
            $('#btn-confirm').removeAttr('disabled');
        } else {
            $('#btn-confirm').attr('disabled', 'disabled');
        }
    })
    // Descelecionar lista ao indicar novo candidato
    $(document).on('focus', '.indication-input', function() {
        $('.dynamic-list-group a').removeClass('btn-list-active');
        $('#idCandidate').val('');

        if ($('#name').val() !== '' || $('#obs').html() != '') {
            $('#btn-confirm').removeAttr('disabled');
        } else {
            $('#btn-confirm').attr('disabled', 'disabled');
        }
    });
    // Validador de CNPJ
    $(document).on('keyup', '#cnpj', function() {
        let cnpj = $(this).val();

        if (cnpj.length == 18) {
            $.ajax({
                url: "/api/validate/cnpj/do/",
                type: "get",
                data: {
                    cnpj: cnpj
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status != 'success') {
                        $('#cnpj').addClass('text-danger').removeClass('text-success');
                    } else {
                        $('#cnpj').addClass('text-success').removeClass('text-danger');
                    }

                    return false;
                },
                error: function(response) {
                    msgPopup(response.status, response.message);

                    return false;
                },
                statusCode: {
                    500: function(){
                        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
                    }
                }
            });
        } else {
            $(this).removeClass('text-success').removeClass('text-danger');
        }
    });
    // Validador de RG
    $(document).on('keyup', '#rg', function() {
        let rg = $(this).val();

        if (rg.length >= 9) {
            $.ajax({
                url: "/api/validate/rg/do/",
                type: "get",
                data: {
                    rg: rg
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status != 'success') {
                        $('#rg').addClass('text-danger').removeClass('text-success');
                    } else {
                        $('#rg').addClass('text-success').removeClass('text-danger');
                    }

                    return false;
                },
                error: function(response) {
                    msgPopup(response.status, response.message);

                    return false;
                },
                statusCode: {
                    500: function(){
                        msgPopup('error', 'Ops! Erro ao verificar o RG.');
                    }
                }
            });
        } else {
            $(this).removeClass('text-success').removeClass('text-danger');
        }
    });
    // Validador de CPF
    $(document).on('keyup', '#cpf', function() {
        let cpf = $(this).val();

        if (cpf.length >= 13) {
            $.ajax({
                url: "/api/validate/cpf/do/",
                type: "get",
                data: {
                    cpf: cpf
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status != 'success') {
                        $('#cpf').addClass('text-danger').removeClass('text-success');
                    } else {
                        $('#cpf').addClass('text-success').removeClass('text-danger');
                    }

                    return false;
                },
                error: function(response) {
                    msgPopup(response.status, response.message);

                    return false;
                },
                statusCode: {
                    500: function(){
                        msgPopup('error', 'Ops! Erro ao verificar o CPF.');
                    }
                }
            });
        } else {
            $(this).removeClass('text-success').removeClass('text-danger');
        }
    });
    // Validador de E-mail
    $(document).on('keyup', '#email, #confirm', function() {
        let email = $(this).val();
        let field = $(this).attr('name');

        if (email.length > 10) {
            $.ajax({
                url: "/api/validate/email/do/",
                type: "get",
                data: {
                    email: email
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status != 'success') {
                        $('#' + field).addClass('text-danger').removeClass('text-success');
                    } else {
                        $('#' + field).addClass('text-success').removeClass('text-danger');
                    }

                    return false;
                },
                error: function(response) {
                    msgPopup(response.status, response.message);

                    return false;
                },
                statusCode: {
                    500: function(){
                        msgPopup('error', 'Ops! Erro ao verificar o E-mail.');
                    }
                }
            });
        } else {
            $(this).removeClass('text-success').removeClass('text-danger');
        }
    });

    // Validador de força da senha
    $(document).on('keyup', '.password', function() {
        let senha = $(this).val();

        if (senha.length > 0) {
            $.ajax({
                url: "/api/validate/password/do/",
                type: "get",
                data: {
                    password: senha
                },
                dataType: 'json',
                success: function(response) {
                    $('#doc-progress-bar').css({
                        'width':response.width + "%",
                    }).removeClass('bg-success').removeClass('bg-warning').removeClass('bg-danger').addClass(response.bgcolor);

                    return false;
                },
                error: function(response) {
                    msgPopup(response.status, response.message);

                    return false;
                },
                statusCode: {
                    500: function(){
                        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
                    }
                }
            });
        } else {
            $('#doc-progress-bar').css({
                'width':"0%",
            }).removeClass('bg-success').removeClass('bg-warning').addClass('bg-danger');

            return false;
        }
    });
});
