<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Ocorrencia;
use Illuminate\Http\Request;

class OcorrenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $successMessage = session('successMessage');
        $ocorrencias = Ocorrencia::orderBy('datahora', 'desc')->take(50)->get();
        return view('ocorrencias.index')
            ->with('ocorrencias', $ocorrencias)
            ->with('successMessage', $successMessage);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $funcionarios = Funcionario::where('ativo', true)->orderBy('nome')->get();
        return view('ocorrencias.create')
            ->with('funcionarios', $funcionarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Ocorrencia::create($request->all());

        return to_route('ocorrencias.index')
            ->with('successMessage', 'Ocorrência criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ocorrencia $ocorrencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ocorrencia $ocorrencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ocorrencia $ocorrencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ocorrencia $ocorrencia)
    {
        $ocorrencia->delete();
        return to_route('ocorrencias.index')
            ->with('successMessage', 'Ocorrência excluída com sucesso!');
    }
}
