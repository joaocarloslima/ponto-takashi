<x-layout titulo="inserir registro">

    <div class="card md">
        <h2>Inserir Registro</h2>

        <form method="POST" action="{{ route('registros.store') }}" class="vertical-form">
            @csrf
            
            <div class="field-group">
                <label for="funcionario_id">Funcionário</label>
    
                <select id="funcionario_id" name="funcionario_id" class="@error('funcionario_id') is-invalid @enderror">
                    @foreach ($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}">
                            {{ $funcionario->nome }}
                        </option>
                    @endforeach
                </select>
    
                @error('funcionario_id')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field-group">
                <label for="datahora">Horário</label>
                <input 
                    type="datetime-local"
                     name="datahora" 
                     id="datahora" 
                     class="@error('datahora') is-invalid @enderror" 
                     value="{{ old('datahora') }}">
            </div>
    

            <button class="button">
                <i class="fa-solid fa-check"></i>
                salvar
            </button>
        </form>
    </div>

</x-layout>
