<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Valida Eleições - Sistema de Eleições</title>
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <link rel="stylesheet" type="text/css" href="{{ url(mix('inc/file/css/global.css')) }}">
    </head>
    <body class="w-100" style="background-color: #EEE;">
      @include('adm/header')
      <p class="m-3 p-3 bg-success text-white">Olá <b class="text-white">{{ session()->get('name') }}</b>, essa é uma área restrita, somente usuários autorizados.</p>
    </body>
    <script src="{{ url(mix('inc/file/js/global.js')) }}"></script>
</html>