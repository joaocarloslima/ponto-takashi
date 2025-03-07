<x-layout titulo="cadastrar feriado">

    <div class="card md">
        <h2>Cadastrar Feriado</h2>

        <form method="POST" action="{{ route('feriados.store') }}" class="vertical-form">
            @csrf
            
            <div class="field-group">
                <label for="nome">Nome</label>
                <input id="nome" name="nome" type="text" class="@error('nome') is-invalid @enderror" value="{{ old('nome') }}"  />
                @error('nome')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                <label for="data">Data</label>
                <input type="date" name="data" id="data" class="@error('data') is-invalid @enderror"  value="{{ old('data') }}" />
                @error('data')
                    <div class="text-error">{{ $message }}</div>
                @enderror

            </div>

            <button class="button">
                <i class="fa-solid fa-check"></i>
                salvar
            </button>
        </form>
    </div>

</x-layout>
