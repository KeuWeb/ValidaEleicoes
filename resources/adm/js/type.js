// Submeter o fomrulário
$('body').on('submit', '#type-adm', function(event) {
    event.preventDefault();

    $.ajax({
        url: $('#route').val(),
        type: "put",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            msgPopup(response.status, response.message);

            return false;
        },
        error: function(response) {
            msgPopup(response.status, response.message);

            return false;
        }
    });
});