<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Ocorrencia;
use App\Models\Registro;
use DateTime;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $successMessage = session('successMessage');

        $registros = Registro::orderBy('datahora', 'desc')->take(50)->get();

        return view('registros.index')
            ->with('registros', $registros)
            ->with('successMessage', $successMessage);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $funcionarios = Funcionario::where('ativo', true)->orderBy('nome')->get();
        return view('registros.create')
            ->with('funcionarios', $funcionarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['manual' => 1]);
        $request->merge(['latitude' => '0']);
        $request->merge(['longitude' => '0']);

        Registro::create($request->all());

        return to_route('registros.index')
            ->with('successMessage', 'Registro cadastrado com sucesso!');
    }

    public function registrar(Request $request)
    {
        $funcionario = Funcionario::where('rfid', $request->input('matricula'))->first();

        if (!$funcionario) {
            return response()->json([
                'message' => 'ID não encontrado!'
            ], 404);
        }

        $request->merge(['funcionario_id' => $funcionario->id]);

        $datahora = (new DateTime('now', new \DateTimeZone('America/Sao_Paulo')))->format('Y-m-d H:i:s');

        $request->merge(['datahora' => $datahora]);
        $request->merge(['latitude' => 0]);
        $request->merge(['longitude' => 0]);
        $request->merge(['manual' => 0]);


        Registro::create($request->all());

        return response()->json([
            'message' => 'Registro realizado com sucesso!'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Registro $registro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registro $registro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registro $registro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registro $registro)
    {
        $registro->delete();
        return to_route('registros.index')
            ->with('successMessage', 'Registro excluído com sucesso!');
    }

    public function relatorio(Request $request)
    {
        // se matricula = X, gerar relatorio geral
        if ($request->input('matricula') == 'X') {
            return $this->relatorioGeral($request);
        }

        $matricula = $request->input('matricula');
        $camposmes = $request->input('mes');
        $ano = substr($camposmes, 0, 4);
        $mes = substr($camposmes, 5, 2);

        $funcionario = Funcionario::where('matricula', $matricula)->first();

        $registros = Registro::whereMonth('datahora', $mes)
            ->whereYear('datahora', $ano)
            ->where('funcionario_id', $funcionario->id)
            ->orderBy('datahora')
            ->get()
            ->groupBy(function ($registro) {
                return \Carbon\Carbon::parse($registro->datahora)->format('d');
            });

        $arrayDias = $this->montarArrayDiasMes($ano, $mes);
        $arrayRegistros = $registros->toArray();
        $maiorNumeroDeRegistros = 0;

        foreach ($arrayDias as &$dia) {
            $indice = $dia['dia'];
            if ($indice < 10) {
                $indice = '0' . $indice;
            }

            if (isset($arrayRegistros[$indice])) {
                $registros = $arrayRegistros[$indice];
                if (count($registros) > $maiorNumeroDeRegistros) {
                    $maiorNumeroDeRegistros = count($registros);
                }

                foreach ($registros as $registro) {
                    $hora = \Carbon\Carbon::parse($registro['datahora'])->format('H:i');
                    $dia['registros'][] = $hora;
                }
            }

            //se houver ocorrencia nesse dia, adicionar no array
            $dataBusca = $ano . '-' . $mes . '-' . $dia['dia'];
            $ocorrencias = Ocorrencia::where('funcionario_id', $funcionario->id)
                                        ->whereDate('datahora', $dataBusca)
                                        ->get();

            foreach ($ocorrencias as $ocorrencia) {
                $dia['ocorrencias'][] = $ocorrencia->descricao;
            }
        }


        unset($dia); // Remova a referência após o loop
        return view("pdf.relatorio")
            ->with('funcionario', $funcionario)
            ->with('dias', $arrayDias)
            ->with('mes', strtoupper($this->getMesPorExtenso($mes)))
            ->with('ano', $ano)
            ->with('maiorNumeroDeRegistros', $maiorNumeroDeRegistros);
    }

    function relatorioGeral(Request $request) {
        $ano = date('Y');
        $mes = date('m');
    
        $funcionarios = Funcionario::where('ativo', true)->orderBy('nome')->get();
        $dadosFuncionarios = []; // Para armazenar os dados de todos os funcionários
    
        foreach ($funcionarios as $funcionario) {
            $matricula = $funcionario->matricula;
            $camposmes = $request->input('mes');
            $ano = substr($camposmes, 0, 4);
            $mes = substr($camposmes, 5, 2);
    
            $registros = Registro::whereMonth('datahora', $mes)
                ->whereYear('datahora', $ano)
                ->where('funcionario_id', $funcionario->id)
                ->orderBy('datahora')
                ->get()
                ->groupBy(function ($registro) {
                    return \Carbon\Carbon::parse($registro->datahora)->format('d');
                });
    
            $arrayDias = $this->montarArrayDiasMes($ano, $mes);
            $arrayRegistros = $registros->toArray();
            $maiorNumeroDeRegistros = 0;
    
            foreach ($arrayDias as &$dia) {
                $indice = $dia['dia'];
                if ($indice < 10) {
                    $indice = '0' . $indice;
                }
    
                if (isset($arrayRegistros[$indice])) {
                    $registros = $arrayRegistros[$indice];
                    if (count($registros) > $maiorNumeroDeRegistros) {
                        $maiorNumeroDeRegistros = count($registros);
                    }
    
                    foreach ($registros as $registro) {
                        $hora = \Carbon\Carbon::parse($registro['datahora'])->format('H:i');
                        $dia['registros'][] = $hora;
                    }
                }
    
                //se houver ocorrencia nesse dia, adicionar no array
                $dataBusca = $ano . '-' . $mes . '-' . $dia['dia'];
                $ocorrencias = Ocorrencia::where('funcionario_id', $funcionario->id)
                                          ->whereDate('datahora', $dataBusca)
                                          ->get();
    
                foreach ($ocorrencias as $ocorrencia) {
                    $dia['ocorrencias'][] = $ocorrencia->descricao;
                }
            }
    
            // Adiciona os dados de cada funcionário no array
            $dadosFuncionarios[] = [
                'funcionario' => $funcionario,
                'dias' => $arrayDias,
                'maiorNumeroDeRegistros' => $maiorNumeroDeRegistros
            ];
        }
    
        // Envia os dados de todos os funcionários para a view
        return view("pdf.relatorios")
            ->with('dadosFuncionarios', $dadosFuncionarios)
            ->with('mes', strtoupper($this->getMesPorExtenso($mes)))
            ->with('ano', $ano);
    }

    function getMesPorExtenso($mes)
    {
        $meses = array(
            "01" => 'Janeiro',
            "02" => 'Fevereiro',
            "03" => 'Março',
            "04" => 'Abril',
            "05" => 'Maio',
            "06" => 'Junho',
            "07" => 'Julho',
            "08" => 'Agosto',
            "09" => 'Setembro',
            "10" => 'Outubro',
            "11" => 'Novembro',
            "12" => 'Dezembro'

        );
        return $meses[$mes];
    }

    function montarArrayDiasMes($ano, $mes)
    {
        $ano = intval($ano);
        $mes = intval($mes);

        if ($mes < 10) {
            $mes = '0' . $mes;
        }
        $primeiroDia = new DateTime("$ano-$mes-01");
        $ultimoDia = new DateTime(date('Y-m-t', strtotime("$ano-$mes-01")));


        $arrayDias = [];

        while ($primeiroDia <= $ultimoDia) {

            $dia = $primeiroDia->format('Y-m-d');
            $diaDaSemana = $primeiroDia->format('N');

            $arrayDias[] = [
                'dia' => intval(date('d', strtotime($dia))),
                'data' => $dia,
                'dataFormatada' => date('d/m/Y', strtotime($dia)),
                'diaDaSemana' => $diaDaSemana,
                'diaDaSemanaNome' => $this->getDiaDaSemana($diaDaSemana),
                'registros' => [],
                'ocorrencias' => []
            ];

            $primeiroDia->modify('+1 day');
        }

        return $arrayDias;
    }

    function getDiaDaSemana($diaDaSemana)
    {
        $nomes = array(
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
            7 => 'Domingo'
        );
        return $nomes[$diaDaSemana];
    }

    public function filtro(Request $request)
    {
        $funcionarios = Funcionario::where('ativo', true)->orderBy('nome')->get();
        return view('registros.filtro')
            ->with('funcionarios', $funcionarios);
    }

    public function dashboard(Request $request)
    {
        $matricula = $request->input('matricula');
        $funcionario = Funcionario::where('matricula', $matricula)->first();

        if (!$funcionario) {
            return response()->json([
                'message' => 'Matrícula não encontrada!'
            ], 404);
        }

        $presencas = $this->getPresencasDoMesAtual($funcionario);

        $primeironome = explode(" ", $funcionario->nome)[0];

        //buscar os ultimos 10 registros do funcionario
        $registros = Registro::where('funcionario_id', $funcionario->id)
            ->orderBy('datahora', 'desc')
            ->take(10)
            ->get();

        foreach ($registros as $registro) {
            $registro->diasemana = $this->getDiaDaSemana(date('w', strtotime($registro->datahora)));
            $registro->hora = date('H:i', strtotime($registro->datahora));
            $registro->datahora = date('d-m', strtotime($registro->datahora));
        }

        return response()->json([
            'nome' => $primeironome,
            'foto' => url('/') . '/' . 'storage/' . $funcionario->foto,
            'registros' => $registros,
            'presencas' => $presencas
        ]);
    }

    private function getPresencasDoMesAtual(Funcionario $funcionario)
    {
        $registros = Registro::where('funcionario_id', $funcionario->id)
            ->whereMonth('datahora', date('m'))
            ->whereYear('datahora', date('Y'))
            ->orderBy('datahora')
            ->get()
            ->groupBy(function ($registro) {
                return \Carbon\Carbon::parse($registro->datahora)->format('d');
            });

        $arrayDias = $this->montarArrayDiasMes(date('Y'), date('m'));
        $arrayRegistros = $registros->toArray();

        foreach ($arrayDias as &$dia) {
            $indice = $dia['dia'];
            $dia['presenca'] = (isset($arrayRegistros[$indice]));
        }

        unset($dia); // Remova a referência após o loop

        return $arrayDias;
    }
}
