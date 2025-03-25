    // Upload de arquivos
    $(document).on('change', '.files', function(event){

        event.preventDefault();

        let form = $(this).attr('data-form');

        $('#upload-' + form + '-adm').ajaxForm({
        uploadProgress: function(event, position, total, percentComplete) {
            $('body').css({
                'cursor':"wait"
            });

            $('#container-' + form + '-progress-bar').removeClass('d-none');

            $('#' + form + '-progress-bar').css({
                'width':percentComplete + "%"
            }).html(percentComplete + "%");

            $('#txt-' + form + '-progress-bar').html('efetuando o upload...').removeClass('text-danger').addClass('text-primary');
        },
        success: function(response) {
            $('body').css({
                'cursor':"default"
            });
            $('#container-' + form + '-progress-bar').addClass('d-none');

            msgPopup(response.status, response.message);

            if (response.status == "success") {
                $('#txt-' + form + '-progress-bar').html("link para o arquivo, <a href='../" + response.link + "' target='_blank'><b class=\"text-success\">clique aqui</b></a>").removeClass('text-primary').addClass('text-success');
                $('#id_upload_' + form).val(response.id);
            } else {
                $('#txt-' + form + '-progress-bar').html('não há arquivo inserido.').removeClass('text-primary').addClass('text-danger');
                $('#upload-' + form).val('');
            }

            if (form == "photo") {
                $('#id_photo').val(response.id);
            }
        },
        error: function(data) {
            $('body').css({
                'cursor':"default"
            });

            $('#container-' + form + '-progress-bar').css({
                'display':"none"
            });

            msgPopup(response.status, response.message);

            $('#txt-' + form + '-progress-bar').val('não há arquivo inserido.').removeClass('text-primary').addClass('text-danger');
        },
        statusCode: {
            500: function() {
                msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
            }
        },
        type:'post',
        dataType:'json',
        url:$('#route-' + form).val(),
        data:$('#upload-' + form + '-adm').serialize(),
        resetForm:false
        }).submit();
    });
