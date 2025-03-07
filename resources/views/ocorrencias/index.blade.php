<x-layout titulo="ocorrencias">
    <h2>Ocorrências</h2>

    @isset($successMessage)
        <div class="alert alert-success">
            {{ $successMessage }}
        </div>
    @endisset

    <div class="toolbar">
        <div class="field">
            <i class="fa-solid fa-magnifying-glass"></i>
            <label for="search" class="hide">Search</label>
            <input type="search" name="search" id="search" placeholder="procurar...">
        </div>
        <a class="button" href="{{ route('ocorrencias.create') }}">
            <i class="fa-solid fa-clock"></i>
            nova ocorrência
        </a>
    </div>

    <ul class="crud-list">
        @foreach ($ocorrencias as $ocorrencia)
            <li class="crud-item">
                <div class="crud-data">
                    <div class="crud-title">
                        <div class="avatar">
                            <img src="{{ asset('storage/' . $ocorrencia->funcionario->foto) }}"
                                onerror="this.onerror=null;this.src='https://i.pravatar.cc/150?img=50'">
                        </div>
                        {{ $ocorrencia->funcionario->nome }} - 
                        <span>{{ $ocorrencia->descricao }}</span>
                    </div>
                    <div class="crud-detail">
                        <div class="user-badge-stat">
                            <i class="fa-solid fa-clock azul"></i>
                            <span>{{ $ocorrencia->dataHoraFormatada }}</span>
                        </div>
                    </div>
                    <div>
                        
                    </div>
                </div>
                <div class="crud-actions">
                    <form action="{{ route('ocorrencias.destroy', $ocorrencia->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="button icon danger" title="apagar ocorrencia">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    <script src="{{ asset('js/search.js') }}" defer></script>
</x-layout>
