<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Valida Eleições - Sistema de Eleições</title>
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <link rel="stylesheet" type="text/css" href="{{ url(mix('inc/file/css/global.css')) }}">
    </head>
    <body style="background-color: #E6E7EB">
      <div class="d-flex justify-content-center">
        <div id="msg-popup" class="animated">
          <i></i>
          <span></span>
          <div class="time-bar bar" data-style="smooth"></div>
        </div>
      </div>
      <div id="container-system-booth-login">
        <div class="container">
          <div class="row justify-content-center align-items-center vh-100">
            <div class="col-4"></div>
            <div id="box-login" data-type="booth" class="col-4 p-5 bg-body border border-2 animated" style="--bs-bg-opacity: 0.7;">
                <div class="text-center">
                  <img src="{{ asset($link) }}" height="50%" width="50%">
                </div>
                <p class="mt-4 mb-4 text-center text-secondary">Esqueci minha Senha</p>
                <form id="forgot-booth" name="forgot-booth" autocomplete="off">
                  @csrf
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Digite o e-mail de cadastro" required>
                    <label for="email">E-mail de cadastro*</label>
                  </div>
                  <div class="form-floating">
                    <input type="text" class="form-control" id="confirm" name="confirm" placeholder="Digite o e-mail novamente" required>
                    <label for="confirm">Confirme o e-mail de cadastro*</label>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <input type="hidden" id="route" name="route" value="{{ route('booth.forgot.do') }}">
                    <input id="btn-forgot" type="submit" value="ENVIAR" class="btn btn-success btn-lg">
                  </div>
                </form>
            </div>
            <div class="col-4"></div>
          </div>
        </div>
      </div>
      <span id="link-copyright">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ url(mix('inc/file/js/global.js')) }}"></script>
    <script src="{{ url(mix('inc/file/js/adm.js')) }}"></script>
</html>
