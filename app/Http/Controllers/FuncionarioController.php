<?php

namespace App\Http\Controllers;

use App\Http\Requests\FuncionarioFormRequest;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $successMessage = session('successMessage');
        //buscar funcionarios ativos 
        $funcionarios = Funcionario::where('ativo', true)->get();

        return view('funcionarios.index')
            ->with('funcionarios', $funcionarios)
            ->with('successMessage', $successMessage);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('funcionarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FuncionarioFormRequest $request)
    {
        
        if ($request->hasFile('image_file')){
            $request->validate([
                'image_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('image_file')->store('funcionarios', 'public');
        }else{
            $image = "funcionarios/default.jpg";
        }
        $request->merge(['foto' => $image]);
        Funcionario::create($request->all());

        return to_route('funcionarios.index')
            ->with('successMessage', 'Funcionário cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Funcionario $funcionario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Funcionario $funcionario)
    {
        return view('funcionarios.edit')->with('funcionario', $funcionario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FuncionarioFormRequest $request, Funcionario $funcionario)
    {
        if ($request->hasFile('image_file')){
            $request->validate([
                'image_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('image_file')->store('funcionarios', 'public');
            $request->merge(['foto' => $image]);
        }

        $funcionario->fill($request->all());
        $funcionario->save();

        return to_route('funcionarios.index')
            ->with('successMessage', 'Funcionário alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Funcionario $funcionario)
    {
        $funcionario->ativo = false;
        $funcionario->save();

        return to_route('funcionarios.index')
            ->with('successMessage', 'Funcionário inativado com sucesso!');
    }

    public function inativos(){
        $successMessage = session('successMessage');

        $funcionarios = Funcionario::where('ativo', false)->get();

        return view('funcionarios.inativos')
            ->with('funcionarios', $funcionarios)
            ->with('successMessage', $successMessage);
    }

    public function ativar(Funcionario $funcionario){
        $funcionario->ativo = true;
        $funcionario->save();

        return to_route('funcionarios.inativos')
            ->with('successMessage', 'Funcionário ativado com sucesso!');
    }

    public function formLogin(){
        return view('funcionarios.login')
            ->with('errorMessage', session('errorMessage'));
    }

    public function logout(){
        auth()->logout();
        return to_route('login');
    }

    public function logar(Request $request){
        $request->validate([
            'matricula' => 'required',
            'password' => 'required'
        ], [
            'matricula.required' => 'O campo matrícula é obrigatório',
            'password.required' => 'O campo senha é obrigatório'
        ]);

        
        $data = $request->only(['matricula', 'password']);
        if (auth()->attempt($data)) {
            return to_route('funcionarios.index');
        }
        return back()->with('errorMessage', 'Acesso negado');
    }



}
