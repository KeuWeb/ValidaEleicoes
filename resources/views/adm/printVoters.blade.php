<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Valida Eleições - Sistema de Eleições</title>
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <link rel="stylesheet" href="{{ asset('/file/css/global.css') }}">
    </head>
    <body class="w-100">
      <div id="container-print" class="mx-auto">
        <div class="w-100 mb-3">
            <img src="{{ asset($logo->link) }}" width="auto" height="80px" alt="" style="display: block;margin: 0 auto;"/>
        </div>

        <h3 class="w-100 text-center pb-3 px-3"><b>ATA DE APURAÇÃO DOS ELEITORES PARTICIPANTES</b></h3>
        <p class="text-justify">Ao(s) <b>{{ date('d', strtotime($election->date_invite)) }}</b> dia(s) do mês <b>{{ date('m', strtotime($election->date_invite)) }}</b> do ano de <b>{{ date('Y', strtotime($election->date_invite)) }}</b>, às <b>{{ date('H:i', strtotime($election->hour_invite)) }}</b> horas, o Sistema efetuou a apuração da lista de eleitores que participaram da(s) <b>{{ $election->title }}</b>,  a apuração foi realizada por meio do sistema eletrônico de eleição <b>Valida Eleições</b>, garantindo a precisão e integridade dos registros.</p>
        <p class="text-justify">Após a verificação dos dados gerados pelo sistema, o <b>Comitê Eleitoral</b> validou a listagem abaixo, atestando a transparência e a legitimidade do processo, em conformidade com as normas estabelecidas. O presente documento reforça o compromisso com a lisura da eleição e o respeito ao direito de participação dos eleitores.</p>
        <p class="text-justify"><b>Listagem do(s) eleitor(es) participante(s)</b>
        @foreach ($voters as $voter)
            <p class="w-100 py-0 px-0 my-0 mx-0">{{ $voter->fullname }} ({{ $voter->cpf ? 'CPF: ' . $voter->cpf : ($voter->rg ? 'RG: '.$voter->rg : ($voter->other_doc ? 'DOCUMENTO: '.$voter->other_doc : 'S/R')) }})</p>
        @endforeach

        <p class="text-justify mt-3">Nada mais havendo a tratar, a presente Ata foi gerada automaticamente pelo sistema e registrada para fins de arquivo e comprovação da lisura do processo eleitoral.</p>
        <p>{{ $client->city }}, {{ date('d/m/Y',strtotime('now')) }}.</p>

        <span class="w-50 pb-5 border-top border-dark border-2" style="display: block;margin-top: 80px;">
            {{ $client->company }}
        </span>

        <p style="margin-bottom: 0;">Registro Eletrônico: <b>{{ $votersToken }}<b></p>
        <i>*documento esse podendo ser validado em keu.tec.br/validaeleicoes/validar</i>
      </div>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script>window.print();</script>
</html>
