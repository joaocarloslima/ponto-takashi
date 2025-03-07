<x-layout titulo="relatório">
    <h2>Imprimir Relatório</h2>


    <div class="card md relatorio">
        <h3>Relatório Mensal por Funcionário</h3>
        <form method="POST" action="{{ route('relatorio') }}" class="vertical-form" target="_blank">
            @csrf
           <input type="text" name="matricula" id="matricula" placeholder="funcionário" list="funcionarios">
            <datalist id="funcionarios">
                @foreach ($funcionarios as $funcionario)
                    <option value="{{ $funcionario->matricula }}">{{ $funcionario->nome }}</option>
                @endforeach
            </datalist>
            <input type="month" name="mes" id="mes" placeholder="mês" value="{{ date('Y-m') }}">
            <button class="button">
                <i class="fa-solid fa-print"></i>
                imprimir
            </button>
        </form>
    </div>

    <div class="card md relatorio">
        <h3>Relatório Mensal Geral</h3>
        <form method="POST" action="{{ route('relatorio') }}" class="vertical-form" target="_blank">
            @csrf
           <input type="hidden" name="matricula" value="X" id="matricula" placeholder="funcionário" list="funcionarios">
            <datalist id="funcionarios">
                @foreach ($funcionarios as $funcionario)
                    <option value="{{ $funcionario->matricula }}">{{ $funcionario->nome }}</option>
                @endforeach
            </datalist>
            <input type="month" name="mes" id="mes" placeholder="mês" value="{{ date('Y-m') }}">
            <button class="button">
                <i class="fa-solid fa-print"></i>
                imprimir
            </button>
        </form>
    </div>

</x-layout>
