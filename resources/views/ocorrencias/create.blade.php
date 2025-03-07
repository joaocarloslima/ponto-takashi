<x-layout titulo="inserir registro">

    <div class="card md">
        <h2>Criar uma ocorrência</h2>
        <p>Ocorrências podem ser faltas, eventos atípicos e atestados.</p>

        <form method="POST" action="{{ route('ocorrencias.store') }}" class="vertical-form">
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
                <label for="descricao">Descrição</label>
                <input 
                    type="text"
                     name="descricao" 
                     id="descricao" 
                     class="@error('descricao') is-invalid @enderror" 
                     value="{{ old('descricao') }}">
            </div>

            <div class="field-group">
                <label for="datahora">Data da Ocorrência</label>
                <input 
                    type="date"
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
