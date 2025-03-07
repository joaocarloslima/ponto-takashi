<x-layout titulo="funcionários">
    <h2>Funcionários Inativos</h2>

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
    </div>

    <ul class="crud-list">
        @foreach ($funcionarios as $funcionario)
            <li class="crud-item">
                <div class="crud-data">
                    <div class="crud-title">
                        <div class="avatar">
                            <img src="{{ asset('storage/' . $funcionario->foto) }}"
                                onerror="this.onerror=null;this.src='https://i.pravatar.cc/150?img=50'">
                        </div>
                        {{ $funcionario->nome }}
                    </div>
                </div>
                <div class="crud-actions">
                    <form action="{{ route('funcionarios.ativar', $funcionario->id) }}" method="POST" title="reativar">
                        @method('PUT')
                        @csrf
                        <button class="button icon warning">
                            <i class="fa-solid fa-user-check"></i>
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    <script src="{{ asset('js/search.js') }}" defer></script>
</x-layout>
