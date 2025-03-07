<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Ponto</title>
</head>

<body>

    <header>
        <div class="logo">
            <h1>PONT<span>O</span> TAKASHI</h1>
        </div>
    </header>




    <div class="card md">
        <h2>
            Entrar
        </h2>
        @isset($errorMessage)
            <div class="alert alert-error">
                {{ $errorMessage }}
            </div>
        @endisset

        <form method="POST" action="{{ route('login') }}" class="vertical-form">
            @csrf

            <div class="field-group">
                <label for="matricula">Matrícula</label>
                <input id="matricula" name="matricula" type="text" value="{{ old('matricula') }}">
                @error('matricula')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                <label for="password">Senha</label>
                <input type="password" name="password" id="password">
                @error('password')
                    <div class="text-error">{{ $message }}</div>
                @enderror

            </div>

            <button class="button">
                <i class="fas fa-sign-in-alt"></i>
                entrar
            </button>
        </form>
    </div>

</body>

</html>
