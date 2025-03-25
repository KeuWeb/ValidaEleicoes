<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Valida Eleições - Sistema de Eleições</title>
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <link rel="stylesheet" href="{{ asset('/file/css/global.css') }}">
    </head>
    <body style="background-color: #E6E7EB">
      <div class="d-flex justify-content-center">
        <div id="msg-popup" class="animated">
          <i></i>
          <span></span>
          <div class="time-bar bar" data-style="smooth"></div>
        </div>
      </div>
      <div id="container-system-adm-login">
        <div class="container">
          <div class="row justify-content-center align-items-center vh-100">
            <div class="col-4"></div>
            <div id="box-login" data-type="adm" class="col-4 p-5 bg-body border border-2 animated" style="--bs-bg-opacity: 0.7;">
                <div class="text-center">
                  <img src="{{ asset($link) }}" height="50%" width="50%">
                </div>
                <p class="mt-4 mb-4 text-center text-secondary">Portal Administrativo das Eleições</p>
                <form id="login-adm" name="login-adm" autocomplete="off">
                  @csrf
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
                    <label for="login">Login*</label>
                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                    <label for="password">Senha*</label>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <input type="hidden" id="route" name="route" value="{{ route('adm.login.do') }}">
                    <input id="btn-login" type="submit" value="EFETUAR LOGIN" class="btn btn-success btn-lg">
                  </div>
                  <p class="text-center mt-3">esqueceu sua senha? <a class="text-success"href="/adm/forgot" target="_self">clique aqui</a></p>
                </form>
            </div>
            <div class="col-4"></div>
          </div>
        </div>
      </div>
      <span id="link-copyright">Valida Eleições - a Keu Technology system</span>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script type="module" src="{{ asset('file/js/login.js') }}"></script>
</html>
