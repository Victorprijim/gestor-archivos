@extends('layouts.app')

@section('titulo', 'Galería de imágenes')

@section('contenido')
    <section class="cabecera-pagina">
        <h1>Galería de imágenes</h1>
        <p>Sube tus fotos, cámbialas o bórralas cuando quieras.</p>
    </section>

    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data" class="formulario">
        @csrf
        <h2>Subir imagen</h2>
        <div class="campo">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="campo">
            <label for="image">Imagen</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" required>
        </div>
        <button type="submit" class="boton">Subir</button>
    </form>

    <section class="galeria">
        @forelse ($photos as $photo)
            <article class="tarjeta">
                <img src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->title }}">
                <h3>{{ $photo->title }}</h3>
                <form action="{{ route('photos.update', $photo) }}" method="POST" enctype="multipart/form-data" class="formulario formulario--mini">
                    @csrf
                    @method('PUT')
                    <label for="image-{{ $photo->id }}">Reemplazar imagen</label>
                    <input type="file" id="image-{{ $photo->id }}" name="image" accept="image/jpeg,image/png,image/gif,image/webp" required>
                    <button type="submit" class="boton boton--secundario">Reemplazar</button>
                </form>
                <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="formulario formulario--mini" onsubmit="return confirm('¿Seguro que quieres eliminar esta imagen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="boton boton--peligro">Eliminar</button>
                </form>
            </article>
        @empty
            <p class="vacio">Todavía no hay imágenes en la galería.</p>
        @endforelse
    </section>
@endsection
