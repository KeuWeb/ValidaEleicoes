// Máscaras ativas
$(document).on('keyup', '.mask', function() {
    let tipo = $(this).attr('data-ref');
    let label = $(this).attr('id');
    // CNPJ
    if (tipo == 'cnpj') {
        $('#' + label).mask('00.000.000/0000-00');
    }
    // RG
    if (tipo == 'rg') {
        $('#' + label).mask('00.000.000-0');
    }
    // CPF
    if (tipo == 'cpf') {
        $('#' + label).mask('000.000.000-00');
    }
    // Telefone, Celular e WhatsApp
    if (tipo == 'phone' || tipo == 'whatsapp' || tipo == 'cellphone') {
        let valor = $('#' + label).val();

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
