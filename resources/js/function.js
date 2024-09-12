// Questionamento quanto a exclusão do registro
$(document).on('click', '.delete', function() {

    id = $(this).attr('data-id');
    module = $(this).attr('data-module');

    $('#idDelete').val(id);

    msgPopup('delete', 'Tem certeza que deseja excluir?');

    return false;
});
// Efetivação da exclusão do registro
$('body').on('submit', '#form-delete', function(event) {
    event.preventDefault();

    $.ajax({
        url: $('#route-delete').val(),
        type: "put",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {

            if (response.status == 'success') {
                $('#line-' + $('#idDelete').val()).css({
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
// Buscador de regitros
$(document).on('click', '#btn-search', function() {
    var search = $('#src').val();
    var module = $('#src').attr('data-module');

    window.location = window.location.href + '?module=' + module + '&src=' + search;
});

$(document).on('change', '.category', function() {

    var location = $('option:selected', this).text();
    var id_location = $(this).val();

    var html_location = "<li class=location-" + id_location + "><span>x</span><p>" + location + "</p></li>";

    $('.txt-locations').css({
        'display': 'none'
    });

    $('.opt-' + id_location).attr('disabled', 'disabled');

    $('.list-locations').append(html_location);
})