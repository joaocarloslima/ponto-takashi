<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
    <title>Relatório de Ponto</title>
</head>

<body>
    @foreach ($dadosFuncionarios as $dadosFuncionario)
    <div class="page">
        <header>
            <img class="logo" src="{{ asset('images/logogoverno.png') }}" alt="Logo">
            <img class="logo" src="{{ asset('images/logocps.png') }}" alt="Logo">
            <img class="logo" src="{{ asset('images/logoetec.png') }}" alt="Logo">
        </header>
        <h1>Relatório de Ponto</h1>

        <h3>Nome: {{ $dadosFuncionario['funcionario']->nome }}</h3>
        <h4>Matrícula: {{ $dadosFuncionario['funcionario']->matricula }}</h4>

        <table>
            <thead>
                <tr>
                    <th colspan="{{ $dadosFuncionario['maiorNumeroDeRegistros'] + 2 }}">FREQUÊNCIA DO MÊS {{ $mes }} DE
                        {{ $ano }}</th>
                </tr>
                <tr>
                    <th colspan="2">DIA</th>
                    <th colspan="{{ $dadosFuncionario['maiorNumeroDeRegistros'] }}">REGISTROS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dadosFuncionario['dias'] as $dia)
                    @if (isset($dia['ocorrencias']) && count($dia['ocorrencias']) > 0)
                        <tr @if ($dia['diaDaSemana'] == 7 || $dia['diaDaSemana'] == 6) class="finalDeSemana" @endif>
                            <td class="small">{{ $dia['diaDaSemanaNome'] }}</td>
                            <td class="small">{{ $dia['dataFormatada'] }}</td>
                            <td colspan="{{ $dadosFuncionario['maiorNumeroDeRegistros'] }}" class="ocorrencia">
                                @for ($i = 0; $i < count($dia['ocorrencias']); $i++)
                                    {{ $dia['ocorrencias'][$i] }}
                                @endfor
                            </td>
                        </tr>
                        @continue
                    @endif
                    <tr @if ($dia['diaDaSemana'] == 7 || $dia['diaDaSemana'] == 6) class="finalDeSemana" @endif>
                        <td class="small">{{ $dia['diaDaSemanaNome'] }}</td>
                        <td class="small">{{ $dia['dataFormatada'] }}</td>

                        @for ($i = 0; $i < $dadosFuncionario['maiorNumeroDeRegistros']; $i++)
                            <td>
                                @if (isset($dia['registros'][$i]))
                                    {{ $dia['registros'][$i] }}
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>De acordo, </p>

        <footer>
            <div class="assinatura">
                <p>_____________________________</p>
                <p>{{ $dadosFuncionario['funcionario']->nome }}</p>
                <p>Assinatura do(a) Funcionário(a)</p>
            </div>
            <div class="assinatura">
                <p>_____________________________</p>
                <p>Franklin P. Gutierrez</p>
                <p>Diretor de Serviço</p>
            </div>
            <div class="assinatura">
                <p>_____________________________</p>
                <p>Álvaro Mendes da Rocha</p>
                <p>Diretor da Unidade</p>
            </div>
        </footer>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    </div>
    @endforeach
</body>

</html>