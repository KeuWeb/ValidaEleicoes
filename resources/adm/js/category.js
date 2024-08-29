// Salvar ou editar dados
$('body').on('submit', '#category-adm', function(event) {
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
                    $('input[type=text]').val('');
                }

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
                msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        }
    });
});
// Buscador de regitros
$(document).on('click', '#btn-search-user', function() {
    var search = $('#src').val();

    window.location = window.location.href + '?src=' + search;
});
// Questionamento quanto a exclusão do registro
$(document).on('click', '.del-user', function() {

    id = $(this).attr('data-id');

    $('#iduser').val(id);

    msgPopup('delete', 'Tem certeza que deseja excluir?');

    return false;
});
// Efetivação da exclusão do registro
$('body').on('submit', '#formuser-delete', function(event) {
    event.preventDefault();

    $.ajax({
        url: $('#route-user').val(),
        type: "put",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {

            if (response.status == 'success') {
                $('#line-' + $('#iduser').val()).css({
                    'display':"none"
                });
            }
            
            msgPopup(response.status, response.message);

            return false;
        },
        error: function(response) {

            msgPopup(response.status, response.message);

            return false;
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        }
    });
});