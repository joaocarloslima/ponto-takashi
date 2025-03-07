<x-layout titulo="feriados">
    <h2>Feriados</h2>

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
        <a class="button" href="{{ route('feriados.create') }}">
            <i class="fa-solid fa-calendar-plus"></i>
            novo feriado
        </a>
    </div>

    <ul class="crud-list">
        @foreach ($feriados as $feriado)
            <li class="crud-item">
                <div class="crud-data">
                    <div class="crud-title">
                        <div class="avatar">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                        {{ $feriado->nome }}
                    </div>
                    <div class="crud-detail">
                        {{ $feriado->dataFormatada }}
                    </div>
                </div>
                <div class="crud-actions">
                    <a class="button icon warning" href="{{ route('feriados.edit', $feriado->id) }}">
                        <i class="fa-solid fa-calendar-check"></i>
                    </a>
                    <form action="{{ route('feriados.destroy', $feriado->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="button icon danger">
                            <i class="fa-regular fa-calendar-xmark"></i>
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    <script src="{{ asset('js/search.js') }}" defer></script>
</x-layout>
