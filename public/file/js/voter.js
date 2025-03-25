// Abilitar campo categoria para listagem respectiva
$(document).on('change', '#local_voter', function() {

    if ($('#local_voter option:selected').val() != '') {
        var route = $(this).attr('data-route-url');

        $.ajax({
            url: route,
            type: "put",
            data: {
                location: $('#local_voter option:selected').val()
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
$('body').on('submit', '#voter-adm', function(event) {
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
                    $('input[type=text],input[type=email],input[type=password]').val('');
                    $('#level').val($("#level option:first").val());
                    $('#doc-progress-bar').css({
                        'width':"0%",
                        'background-color':"#E9ECEF"
                    });
                    $('#local_voter').prop('selectedIndex', 0);
                    $('#category').html('<option value="" selected="selected">Categoria*</option>').attr('disabled', 'disabled');
                } else {
                    var newURL = $('#local_voter option:selected').val();
                    history.pushState({ path: newURL }, '', newURL);
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
// Ação para abertura da modal de informações (Booth > Eleição)
$(document).on('click', '.info-voter', function (e) {
    e.preventDefault();

    let idVoter = $(this).attr('data-voter');

    $.ajax({
        url: "/adm/voter/info",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            idVoter: idVoter
        },
        dataType: "json",
        success: function(response) {
            $('#container-system-adm').css({
                'filter':'blur(5px)'
            });

            setTimeout(function() {
                $('#container-info').html(response.html);

                $('#modal-info').css({
                    'display':"block"
                }).removeClass('fadeOutUpBig').addClass('fadeInDownBig').attr('data-status',"on");
            }, 300);
        },
        error: function(xhr) {
            msgPopup(response.status, response.message);
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        }
    });
});
// Ação para fechar a modal de informações (Booth > Eleição)
$(document).on('click', '.btn-close-modal-info', function() {
    $('#modal-info').removeClass('fadeInDownBig').addClass('fadeOutUpBig').attr('data-status',"off");

    setTimeout(function() {
        $('#modal-info').css({
            'display':"none"
        });

        $('#container-info').html('');

        $('#container-system-adm').css({
            'filter':'none'
        });
    }, 400);
});
// Botão de impressão
$(document).on('click','#btn-print', function() {
    window.open('printVoters','_blank');
});
