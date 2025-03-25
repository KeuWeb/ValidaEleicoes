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

        <h3 class="w-100 text-center pb-3 px-3"><b>ATA DE APURAÇÂO DE ELEIÇÃO</b></h3>
        <p class="text-justify">Ao(s) <b>{{ date('d', strtotime($election->date_invite)) }}</b> dia(s) do mês <b>{{ date('m', strtotime($election->date_invite)) }}</b> do ano de <b>{{ date('Y', strtotime($election->date_invite)) }}</b>, às <b>{{ date('H:i', strtotime($election->hour_invite)) }}</b> horas, foi realizada a apuração dos votos da <b>{{ $election->title }}</b> ocorrida de forma online, por meio do sistema eletrônico <b>Valida Eleições</b>, para a(s) escolha(s) de <b>{{ $cardsNames }}</b>.</p>
        <p class="text-justify">O processo eleitoral transcorreu de maneira segura e transparente, garantindo o sigilo e a integridade dos votos. O sistema registrou automaticamente os votos dos eleitores, assegurando a lisura da eleição e a conformidade com as normas estabelecidas no regulamento eleitoral vigente.</p>
        <p class="text-justify">A apuração foi realizada pelo próprio sistema, que contabilizou os votos de maneira automática, sem qualquer interferência humana, garantindo total imparcialidade. Após o encerramento da votação, obteve-se o seguinte resultado:</p>

        @foreach ($cards as $card)
                    <p><b>{{ $card->title }}</b><br>
                        @php
                         $pos = 1;
                        @endphp
                            @foreach ($card->candidatesList as $candidate)
                                @if ($pos == 1)
                                    {{ $pos }}º {{ $candidate['name'] }} - {{ $candidate['votes'] }} voto(s)<br>
                                @php
                                    $pos++;
                                @endphp
                                @else
                                    {{ $candidate['name'] }} - {{ $candidate['votes'] }} voto(s)<br>
                                @endif
                            @endforeach
                    <b>Total apurado: </b>{{ $card->totalVotes }} voto(s)</p>
        @endforeach

        <p class="text-justify">Diante do resultado, declarou-se eleito(s) o(s) candidato(s) citado(s) em primeira posição, com seu(s) respectivo(s) número(s) de voto(s), para o(s) cargo(s) citado(s), conforme disposto no regulamento eleitoral vigente.</p>
        <p class="text-justify">Nada mais havendo a tratar, a presente ata foi gerada automaticamente pelo sistema e registrada para fins de arquivo e comprovação da lisura do processo eleitoral.</p>
        <p>{{ $client->city }}, {{ date('d/m/Y',strtotime('now')) }}.</p>

        <span class="w-50 pb-5 border-top border-dark border-2" style="display: block;margin-top: 80px;">
            {{ $client->company }}
        </span>

        <p style="margin-bottom: 0;">Registro Eletrônico: <b>{{ $coutingToken }}<b></p>
        <i>*documento esse podendo ser validado em keu.tec.br/validaeleicoes/validar</i>
      </div>
    </body>
    <script src="{{ asset('file/jquery/dist/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('file/js/global.js') }}"></script>
    <script>window.print();</script>
</html>
