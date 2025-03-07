<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Ponto - {{ $titulo }}</title>
</head>

<body>
    <header>
        <div class="logo">
            <h1>PONT<span>O</span> TAKASHI</h1>
        </div>
        <div class="userdata">
            <div class="avatar">
                <img class="avatar" src="{{ asset('storage/' . auth()->user()->foto) }}"
                    onerror="this.onerror=null;this.src='https://i.pravatar.cc/150?img=50'">
            </div>
            {{ auth()->user()->nome }}
            <a href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </header>

    <div class="container">
        <x-menu />

        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
