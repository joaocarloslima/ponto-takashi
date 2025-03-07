<x-layout titulo="registros">
    <h2>Registros</h2>

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
        <a class="button" href="{{ route('registros.create') }}">
            <i class="fa-solid fa-clock"></i>
            novo registros
        </a>
    </div>

    <ul class="crud-list">
        @foreach ($registros as $registro)
            <li class="crud-item">
                <div class="crud-data">
                    <div class="crud-title">
                        <div class="avatar">
                            <img src="{{ asset('storage/' . $registro->funcionario->foto) }}"
                                onerror="this.onerror=null;this.src='https://i.pravatar.cc/150?img=50'">
                        </div>
                        {{ $registro->funcionario->nome }}
                    </div>
                    <div class="crud-detail">
                        <div class="user-badge-stat">
                            <i class="fa-solid fa-clock azul"></i>
                            <span>{{ $registro->dataHoraFormatada }}</span>
                        </div>
                    </div>
                </div>
                <div class="crud-actions">
                    <form action="{{ route('registros.destroy', $registro->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="button icon danger" title="apagar registro">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    <script src="{{ asset('js/search.js') }}" defer></script>
</x-layout>
