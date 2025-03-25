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
$(document).on('click', '#btn-search-category', function() {
    let search = $('#src').val();

    window.location = window.location.href + '?src=' + search;
});
// Questionamento quanto a exclusão do registro
$(document).on('click', '.del-category', function() {

    let id = $(this).attr('data-id');

    $('#idcategory').val(id);

    msgPopup('delete', 'Tem certeza que deseja excluir?');

    return false;
});
