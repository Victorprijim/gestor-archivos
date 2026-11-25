<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->get();

        return view('docs.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            ],
            [
                'title.required' => 'El título es obligatorio.',
                'document.required' => 'Tienes que seleccionar un PDF.',
                'document.file' => 'El archivo no es válido.',
                'document.mimes' => 'El archivo tiene que ser un PDF.',
                'document.max' => 'El PDF no puede superar los 10 MB.',
            ]
        );

        Document::create([
            'title' => $data['title'],
            'path' => $request->file('document')->store('docs', 'public'),
        ]);

        return redirect()->route('docs.index')->with('ok', 'El documento se ha subido correctamente.');
    }

    public function update(Request $request, Document $document)
    {
        $request->validate(
            [
                'document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            ],
            [
                'document.required' => 'Tienes que seleccionar un PDF.',
                'document.file' => 'El archivo no es válido.',
                'document.mimes' => 'El archivo tiene que ser un PDF.',
                'document.max' => 'El PDF no puede superar los 10 MB.',
            ]
        );

        if ($document->path) {
            Storage::disk('public')->delete($document->path);
        }

        $document->update([
            'path' => $request->file('document')->store('docs', 'public'),
        ]);

        return redirect()->route('docs.index')->with('ok', 'El documento se ha reemplazado correctamente.');
    }

    public function destroy(Document $document)
    {
        if ($document->path) {
            Storage::disk('public')->delete($document->path);
        }

        $document->delete();

        return redirect()->route('docs.index')->with('ok', 'El documento se ha eliminado correctamente.');
    }
}
