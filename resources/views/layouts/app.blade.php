<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') | Gestor de archivos</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <header class="cabecera">
        <div class="contenedor cabecera__interior">
            <a href="{{ route('photos.index') }}" class="logo">Gestor de archivos</a>
            <nav class="menu">
                <a href="{{ route('photos.index') }}" class="{{ request()->is('photos*') ? 'activo' : '' }}">Galería</a>
                <a href="{{ route('docs.index') }}" class="{{ request()->is('docs*') ? 'activo' : '' }}">Documentos</a>
            </nav>
        </div>
    </header>

    <main class="contenedor">
        @if (session('ok'))
            <p class="aviso aviso--ok">{{ session('ok') }}</p>
        @endif

        @if ($errors->any())
            <ul class="aviso aviso--error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @yield('contenido')
    </main>
</body>
</html>
