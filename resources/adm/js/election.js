// Submeter o fomrulário
$('body').on('submit', '#ele-adm', function(event) {
    event.preventDefault();

    $.ajax({
        url: $('#route').val(),
        type: "put",
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            
            msgPopup(response.status, response.message);

            $('#idIndication').val(response.idInd);
            $('#idElection').val(response.idEle);

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