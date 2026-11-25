@extends('layouts.app')

@section('titulo', 'Gestor de documentos')

@section('contenido')
    <section class="cabecera-pagina">
        <h1>Gestor de documentos</h1>
        <p>Sube archivos PDF, ábrelos en otra pestaña, reemplázalos o elimínalos.</p>
    </section>

    <form action="{{ route('docs.store') }}" method="POST" enctype="multipart/form-data" class="formulario">
        @csrf
        <h2>Subir documento</h2>
        <div class="campo">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="campo">
            <label for="document">Archivo PDF</label>
            <input type="file" id="document" name="document" accept="application/pdf" required>
        </div>
        <button type="submit" class="boton">Subir</button>
    </form>

    <section class="listado">
        @forelse ($documents as $document)
            <article class="fila-doc">
                <a href="{{ asset('storage/'.$document->path) }}" target="_blank" rel="noopener">{{ $document->title }}</a>
                <form action="{{ route('docs.update', $document) }}" method="POST" enctype="multipart/form-data" class="formulario formulario--mini">
                    @csrf
                    @method('PUT')
                    <label for="document-{{ $document->id }}">Reemplazar PDF</label>
                    <input type="file" id="document-{{ $document->id }}" name="document" accept="application/pdf" required>
                    <button type="submit" class="boton boton--secundario">Reemplazar</button>
                </form>
                <form action="{{ route('docs.destroy', $document) }}" method="POST" class="formulario formulario--mini" onsubmit="return confirm('¿Seguro que quieres eliminar este documento?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="boton boton--peligro">Eliminar</button>
                </form>
            </article>
        @empty
            <p class="vacio">Todavía no hay documentos.</p>
        @endforelse
    </section>
@endsection
