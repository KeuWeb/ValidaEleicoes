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
      <div id="container-system">
        <div class="container">
          <div class="row justify-content-center align-items-center vh-100">
            <div class="col-4"></div>
            <div class="col-4 p-5 bg-body border border-2">
                <div class="text-center">
                  <img src="../inc/file/img/logo.png" alt="Valida Eleições" height="100" width="200">
                </div>
                <p class="mt-4 mb-4 text-center text-secondary">Portal Administrativo</p>
                <form id="login-adm" name="login-adm" autocomplete="off">
                  @csrf
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="login" name="login" placeholder="Login">
                    <label for="login">Login*</label>
                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
                    <label for="password">Senha*</label>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <input type="hidden" id="route" name="route" value="{{ route('adm.login.do') }}">
                    <input id="btn-login" type="submit" value="EFETUAR LOGIN" class="btn btn-success btn-lg">
                  </div>
                  <p class="text-center mt-3">esqueceu sua senha? <b class="text-success" style="cursor: pointer;">clique aqui</b></p>
                </form>
            </div>
            <div class="col-4"></div>
          </div>
        </div>
      </div>
    </body>
    <script src="{{ url(mix('inc/file/js/global.js')) }}"></script>
    <script src="{{ url(mix('inc/file/js/adm.js')) }}"></script>
</html>