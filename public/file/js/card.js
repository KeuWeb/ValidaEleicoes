// Abilitar campo categoria para listagem respectiva
$(document).on('change', '#local_card', function() {

    if ($('#local_card option:selected').val() != '') {
        let route = $(this).attr('data-route-url');

        $.ajax({
            url: route,
            type: "put",
            data: {
                location: $('#local_card option:selected').val()
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
$('body').on('submit', '#card-adm', function(event) {
    event.preventDefault();

    $('#salvar').val('AGUARDE...').attr('disabled','disabled');

    $.ajax({
        url: $('#route').val(),
        type: "put",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {

            msgPopup(response.status, response.message);

            $('#salvar').val('SALVAR').removeAttr('disabled');

            if (response.status == "success") {
                if($('#id').val() == ""){
                    $('input[type=text],input[type=number]').val('');
                    // $('#level').val($("#level option:first").val());
                    $('#limit_votes').val(1);
                    $('#local_card').prop('selectedIndex', 0);
                    $('#category').html('<option value="" selected="selected">Categoria*</option>').attr('disabled', 'disabled');
                }
            }

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
