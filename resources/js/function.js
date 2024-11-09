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
// Seleção de categorias (modulo Localidades)
$(document).on('change', '.category', function() {

    var location = $('option:selected', this).text();
    var id_location = $('option:selected', this).val();

    if (id_location != "") {
        var html_location = "<li class=location-" + id_location + "><span data-id=\"" + id_location + "\" class=\"dlt-cat\"><i class=\"bi bi-trash-fill pt-1 text-white\"></i></span><p>" + location + "</p></li>";

        console.log(html_location);

        if (id_location == 0) {
            $('.list-locations').html(html_location);
            $('#categories').val(id_location);
            $('select option').removeAttr('disabled');
        } else {
            if (id_location == 0) {
                $('.list-locations').html('');
                $('#categories').val('');
            }
        
            $('.opt-' + id_location).attr('disabled', 'disabled');
        
            $('.list-locations').append(html_location);
    
            if ($('.list-locations li').length == 1) {
                $('#categories').val(id_location);
            } else if ($('.list-locations li').length > 1) {
                $('#categories').val($('#categories').val() + ',' + id_location);
            } else {
                $('#categories').val('');
            }
    
        }

        $('.txt-locations').css({
            'display': 'none'
        });
    }

});
// Exclusão de categorias selecionadas
$(document).on('click', '.dlt-cat', function() {

    var id_location = $(this).attr('data-id');

    $('.opt-' + id_location).removeAttr('disabled');
    $('.location-' + id_location).remove();

    var categories = $('#categories').val();
    var arr_categories = categories ? categories.split(',') : [];

    arr_categories = arr_categories.filter(function (item) {
        return item !== id_location;
    });

    $('#categories').val(arr_categories.join(','));

    if ($('.list-locations li').length == 0) {
        $('.txt-locations').css({
            'display': 'block'
        });
    }
});
