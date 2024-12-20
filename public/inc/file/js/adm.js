/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!***********************************!*\
  !*** ./resources/adm/js/login.js ***!
  \***********************************/
// Submeter o fomrulário
$('body').on('submit', '#login-adm', function (event) {
  event.preventDefault();
  $('#btn-login').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "post",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      if (response.status == "success") {
        setTimeout(function () {
          window.location = "adm/cpanel";
        }, 3000);
      }
      $('#btn-login').val('EFETUAR LOGIN').removeAttr('disabled');
      msgPopup(response.status, response.message);
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#btn-login').val('EFETUAR LOGIN').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar o login, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**********************************!*\
  !*** ./resources/adm/js/type.js ***!
  \**********************************/
// Submeter o fomrulário
$('body').on('submit', '#type-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**********************************!*\
  !*** ./resources/adm/js/form.js ***!
  \**********************************/
// Submeter o fomrulário
$('body').on('submit', '#form-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**********************************!*\
  !*** ./resources/adm/js/rule.js ***!
  \**********************************/
// Submeter o fomrulário
$('body').on('submit', '#rule-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*******************************************!*\
  !*** ./resources/adm/js/communication.js ***!
  \*******************************************/
// Submeter o formulário
$('body').on('submit', '#communication-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*************************************!*\
  !*** ./resources/adm/js/mailing.js ***!
  \*************************************/
// Submeter o fomrulário
$('body').on('submit', '#mailing-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('EMVIANDO...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('ENVIAR').removeAttr('disabled');
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('ENVIAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**************************************!*\
  !*** ./resources/adm/js/election.js ***!
  \**************************************/
// Submeter o fomrulário
$('body').on('submit', '#ele-adm', function (event) {
  event.preventDefault();
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      $('#idIndication').val(response.idInd);
      $('#idElection').val(response.idEle);
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**********************************!*\
  !*** ./resources/adm/js/user.js ***!
  \**********************************/
// Salvar ou editar dados
$('body').on('submit', '#user-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      if (response.status == "success") {
        if ($('#id').val() == "") {
          $('input[type=text],input[type=email],input[type=password]').val('');
          $('#level').val($("#level option:first").val());
          $('#doc-progress-bar').css({
            'width': "0%",
            'background-color': "#E9ECEF"
          });
        }
        $('#id').val($idUser);
      }
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!***********************************!*\
  !*** ./resources/adm/js/voter.js ***!
  \***********************************/
// Abilitar campo categoria para listagem respectiva
$(document).on('change', '#local_voter', function () {
  if ($('#local_voter option:selected').val() != '') {
    var route = $(this).attr('data-route-url');
    $.ajax({
      url: route,
      type: "put",
      data: {
        location: $('#local_voter option:selected').val()
      },
      dataType: 'json',
      success: function success(response) {
        if (response.status == "success") {
          $('#category').html(response.html).removeAttr('disabled');
        } else {
          $('#category').attr('disabled', 'disabled');
        }
        return false;
      },
      error: function error() {
        msgPopup('error', 'Ops! Falha ao buscar a lista da(s) categoria(s)');
        return false;
      },
      statusCode: {
        500: function _() {
          msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
        }
      }
    });
  }
});
// Salvar ou editar dados
$('body').on('submit', '#voter-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      if (response.status == "success") {
        if ($('#id').val() == "") {
          $('input[type=text],input[type=email],input[type=password]').val('');
          $('#level').val($("#level option:first").val());
          $('#doc-progress-bar').css({
            'width': "0%",
            'background-color': "#E9ECEF"
          });
          $('#local_voter').prop('selectedIndex', 0);
          $('#category').html('<option value="" selected="selected">Categoria*</option>').attr('disabled', 'disabled');
        }
      }
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**************************************!*\
  !*** ./resources/adm/js/category.js ***!
  \**************************************/
// Salvar ou editar dados
$('body').on('submit', '#category-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      if (response.status == "success") {
        if ($('#id').val() == "") {
          $('input[type=text]').val('');
        }
      }
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
// Buscador de regitros
$(document).on('click', '#btn-search-category', function () {
  var search = $('#src').val();
  window.location = window.location.href + '?src=' + search;
});
// Questionamento quanto a exclusão do registro
$(document).on('click', '.del-category', function () {
  id = $(this).attr('data-id');
  $('#idcategory').val(id);
  msgPopup('delete', 'Tem certeza que deseja excluir?');
  return false;
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*************************************!*\
  !*** ./resources/adm/js/company.js ***!
  \*************************************/
// Submeter o fomrulário
$('body').on('submit', '#company-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    dataType: 'json',
    success: function success(response) {
      msgPopup(response.status, response.message);
      if (response.status == "success") {
        $('#id').val(response.id);
      }
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**************************************!*\
  !*** ./resources/adm/js/location.js ***!
  \**************************************/
// Salvar ou editar dados
$('body').on('submit', '#location-adm', function (event) {
  event.preventDefault();
  $('#salvar').val('AGUARDE...').attr('disabled', 'disabled');
  $.ajax({
    url: $('#route').val(),
    type: "put",
    data: $(this).serialize(),
    cache: false,
    dataType: 'json',
    success: function success(response) {
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
    error: function error(response) {
      msgPopup(response.status, response.message);
      $('#salvar').val('SALVAR').removeAttr('disabled');
      return false;
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    }
  });
});
// Buscador de regitros
$(document).on('click', '#btn-search-location', function () {
  var search = $('#src').val();
  window.location = window.location.href + '?src=' + search;
});
// Questionamento quanto a exclusão do registro
$(document).on('click', '.del-location', function () {
  id = $(this).attr('data-id');
  $('#idlocation').val(id);
  msgPopup('delete', 'Tem certeza que deseja excluir?');
  return false;
});
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*************************************!*\
  !*** ./resources/adm/js/uploads.js ***!
  \*************************************/
// Upload de arquivos
$(document).on('change', '.files', function (event) {
  event.preventDefault();
  form = $(this).attr('data-form');
  $('#upload-' + form + '-adm').ajaxForm({
    uploadProgress: function uploadProgress(event, position, total, percentComplete) {
      $('body').css({
        'cursor': "wait"
      });
      $('#container-' + form + '-progress-bar').removeClass('d-none');
      $('#' + form + '-progress-bar').css({
        'width': percentComplete + "%"
      }).html(percentComplete + "%");
      $('#txt-' + form + '-progress-bar').html('efetuando o upload...').removeClass('text-danger').addClass('text-primary');
    },
    success: function success(response) {
      $('body').css({
        'cursor': "default"
      });
      $('#container-' + form + '-progress-bar').addClass('d-none');
      msgPopup(response.status, response.message);
      if (response.status == "success") {
        $('#txt-' + form + '-progress-bar').html("link para o arquivo, <a href='../" + response.link + "' target='_blank'><b class=\"text-success\">clique aqui</b></a>").removeClass('text-primary').addClass('text-success');
      } else {
        $('#txt-' + form + '-progress-bar').html('não há arquivo inserido.').removeClass('text-primary').addClass('text-danger');
        $('#upload-' + form).val('');
      }
    },
    error: function error(data) {
      $('body').css({
        'cursor': "default"
      });
      $('#container-' + form + '-progress-bar').css({
        'display': "none"
      });
      msgPopup(response.status, response.message);
      $('#txt-' + form + '-progress-bar').val('não há arquivo inserido.').removeClass('text-primary').addClass('text-danger');
    },
    statusCode: {
      500: function _() {
        msgPopup('error', 'Ops! Erro ao efetuar solicitação, tente mais tarde.');
      }
    },
    type: 'post',
    dataType: 'json',
    url: $('#route-' + form).val(),
    data: $('#upload-' + form + '-adm').serialize(),
    resetForm: false
  }).submit();
});
})();

/******/ })()
;