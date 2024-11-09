// Validador de CNPJ
$(document).ready(function() {
    $(document).on('keyup', '#cnpj', function() {        
        cnpj = $(this).val();
        
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
        rg = $(this).val();
        
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
        cpf = $(this).val();
        
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
    $(document).on('keyup', '#email', function() {        
        email = $(this).val();
        
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
                        $('#email').addClass('text-danger').removeClass('text-success');
                    } else {
                        $('#email').addClass('text-success').removeClass('text-danger');
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
        senha = $(this).val();

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