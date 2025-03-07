<div class="card md">
    <h2>
        @isset($update)
            Editar Funcionário
        @else
            Cadastrar Funcionário
        @endisset
    </h2>

    <form method="POST" action="{{ $action }}" class="vertical-form" enctype="multipart/form-data">
        @csrf
        @isset($update)
            @method('PUT')
        @endisset
    
        <div class="field-group">
            <label for="matricula">Matrícula</label>
            <input id="matricula"
                name="matricula"
                type="text"
                @isset($update) 
                    value="{{ $funcionario->matricula }}" 
                @else
                    value="{{ old('matricula') }}"
                @endisset
                class="@error('matricula') is-invalid @enderror"
            >
            @error('matricula')
                <div class="text-error">{{ $message }}</div>
            @enderror

            <label for="nome">Nome</label>
            <input id="nome"
                name="nome"
                type="text"
                @isset($update) 
                    value="{{ $funcionario->nome }}" 
                @else
                    value="{{ old('nome') }}"
                @endisset
                class="@error('nome') is-invalid @enderror"
            >
            @error('nome')
                <div class="text-error">{{ $message }}</div>
            @enderror

            <label for="email">E-mail</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="@error('email') is-invalid @enderror" 
                @isset($update) 
                    value="{{ $funcionario->email }}" 
                @else
                    value="{{ old('email') }}"
                @endisset
            >
            @error('email')
                <div class="text-error">{{ $message }}</div>
            @enderror

            <label for="telefone">Telefone</label>
            <input 
                type="text" 
                name="telefone" 
                id="telefone" 
                class="@error('telefone') is-invalid @enderror" 
                @isset($update) 
                    value="{{ $funcionario->telefone }}" 
                @else
                    value="{{ old('telefone') }}"
                @endisset
            >
            @error('telefone')
                <div class="text-error">{{ $message }}</div>
            @enderror

            <label for="image_file">Foto</label>
            <input type="file" name="image_file" id="image_file" accept="image/jpeg, image/png">
            @error('image_file')
                <div class="text-error">{{ $message }}</div>
            @enderror

        </div>

        <button class="button">
            <i class="fa-solid fa-check"></i>
            salvar
        </button>
    </form>
</div>