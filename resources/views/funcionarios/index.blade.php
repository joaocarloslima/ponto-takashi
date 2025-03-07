<x-layout titulo="funcionários">
    <h2>Funcionários</h2>

    <div class="mission-stats">

        <div class="mission-stat">
            <div class="mission-stat-icon verde">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="mission-stat-number">
                {{ $funcionarios->get(0)->totalAtivos() }}
            </div>
            <span>funcionários ativos</span>
        </div>
        <div class="mission-stat">
            <div class="mission-stat-icon laranja">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="mission-stat-number">
                {{ $funcionarios->get(0)->totalInativos() }}
            </div>
            <span>funcionários inativos</span>
        </div>
        <div class="mission-stat">
            <div class="mission-stat-icon">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="mission-stat-number">
                {{ $funcionarios->get(0)->total() }}
            </div>
            <span>total de funcionários</span>
        </div>
    </div>

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
        <a class="button" href="{{ route('funcionarios.create') }}">
            <i class="fa-solid fa-user-plus"></i>
            novo funcionário
        </a>
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
                    <a class="button icon warning" href="{{ route('funcionarios.edit', $funcionario->id) }}">
                        <i class="fa-solid fa-user-pen"></i>
                    </a>
                    <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="button icon danger">
                            <i class="fa-solid fa-user-xmark"></i>
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    <script src="{{ asset('js/search.js') }}" defer></script>
</x-layout>
