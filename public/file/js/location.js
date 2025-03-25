// Salvar ou editar dados
$('body').on('submit', '#location-adm', function(event) {
    event.preventDefault();

    $('#salvar').val('AGUARDE...').attr('disabled','disabled');

    $.ajax({
        url: $('#route').val(),
        type: "put",
        data: $(this).serialize(),
        cache: false,
        dataType: 'json',
        success: function(response) {

            msgPopup(response.status, response.message);

            if (response.status == "success") {

                if ($('#id').val() == "") {
                    $('input[type=text]').val('');
                    $('#categories').val('');
                    $('.container-locations').html('<li class="txt-locations">Não há categoria(s) selecionada(s) para a localidade.</li><li class="box-locations"><ul class="list-locations"></ul></li>');
                    $('select option').removeAttr('disabled');
                    $('select').prop('selectedIndex', 0);
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
$(document).on('click', '#btn-search-location', function() {
    let search = $('#src').val();

    window.location = window.location.href + '?src=' + search;
});
// Questionamento quanto a exclusão do registro
$(document).on('click', '.del-location', function() {

    let id = $(this).attr('data-id');

    $('#idlocation').val(id);

    msgPopup('delete', 'Tem certeza que deseja excluir?');

    return false;
});
