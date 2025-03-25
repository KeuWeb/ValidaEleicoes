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
                <p class="mt-4 mb-4 text-center text-secondary">Cadastre a nova senha de acesso:</p>
                <form id="reset-booth" name="reset-booth" autocomplete="off">
                  @csrf
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Digite a nova senha" required>
                    <label for="password">Nova senha*</label>
                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Digite a nova senha novamente" required>
                    <label for="confirm">Confirme a nova senha*</label>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <input type="hidden" id="token" name="token" value="{{ $token }}">
                    <input type="hidden" id="route" name="route" value="{{ route('booth.reset.do') }}">
                    <input id="btn-reset" type="submit" value="SALVAR" class="btn btn-success btn-lg">
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
