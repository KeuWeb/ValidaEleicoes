// Busca de dados relativo ao CEP digitado
$(document).on('keyup', '#cep', function() {
    let info = $(this).val();

    if (info.length == 9) {

        $('.loader').removeClass('d-none');

        $.ajax({
            url: "/api/cep/do/",
            type: "get",
            data: {
                cep: info
            },
            dataType: 'json',
            success: function(response) {
                msgPopup(response.status, response.message);

                $('.loader').addClass('d-none');

                if (response.status != "alert" && response.status != "error") {
                    $('#street').val(response.logradouro);
                    $('#neighborhood').val(response.bairro);
                    $('#city').val(response.localidade);
                    $("#uf option[value=" + response.uf + "]").attr('selected','selected');
                    $('#cep').addClass('text-success');
                } else {
                    $('#cep').removeClass('text-success');
                }

                return false;
            },
            error: function(response) {

                msgPopup(response.status, response.message);

                $('.loader').addClass('d-none');

                return false;
            },
            statusCode: {
                500: function() {
                    msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
                }
            }
        });
    } else {
        $('.loader').addClass('d-none');
    }

    return false;
});
