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
                        msgPopup(response.status, response.message);  
                        
                        $('#cnpj').removeClass('text-success');
                    } else {
                        $('#cnpj').addClass('text-success');
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
            $(this).removeClass('text-success');
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