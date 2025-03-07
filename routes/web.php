<?php

use App\Http\Controllers\FeriadoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\RegistroController;
use App\Models\Funcionario;
use App\Models\Registro;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return to_route('funcionarios.index');
});

Route::middleware('auth')->group(function () {


    Route::resource('funcionarios', FuncionarioController::class);
    Route::resource('feriados', FeriadoController::class);
    Route::resource('registros', RegistroController::class);
    Route::resource('ocorrencias', OcorrenciaController::class);

    Route::get('inativos', [FuncionarioController::class, 'inativos'])->name('funcionarios.inativos');
    Route::put('inativos/{funcionario}', [FuncionarioController::class, 'ativar'])->name('funcionarios.ativar');

    Route::post('relatorios', [RegistroController::class, 'relatorio'])->name('relatorio');
    Route::get('relatorios', [RegistroController::class, 'filtro'])->name('relatorio.filtro');

});

Route::get('login', [FuncionarioController::class, 'formLogin'])->name('login');
Route::post('login', [FuncionarioController::class, 'logar'])->name('logar');
Route::get('logout', [FuncionarioController::class, 'logout'])->name('logout');