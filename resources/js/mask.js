// Máscaras ativas
$(document).on('keyup', '.mask', function() {
    tipo = $(this).attr('data-ref');
    label = $(this).attr('id');
    // CNPJ
    if (tipo == 'cnpj') {
        $('#' + label).mask('00.000.000/0000-00');
    }

    if (tipo == 'phone' || tipo == 'whatsapp') {
        valor = $('#' + label).val();
        
        regra = function (valor) {
            if (valor.replace(/\D/g, '').length === 11) {
                return '(00)00000-0000';
            } else {
                return '(00)0000-00009';
            }
        },
            
        $('#' + label).mask(regra);
    }
    // CEP
    if (tipo == 'cep') {
        $('#' + label).mask('00000-000');
    }
    // Milisegundos
    if (tipo == 'time') {
        $('#' + label).mask('00000');
    }
    // Votos
    if (tipo == 'difvotes') {
        $('#' + label).mask('000');
    }
}); 