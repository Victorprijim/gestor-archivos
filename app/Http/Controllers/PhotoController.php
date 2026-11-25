<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->get();

        return view('photos.index', compact('photos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
            ],
            [
                'title.required' => 'El título es obligatorio.',
                'image.required' => 'Tienes que seleccionar una imagen.',
                'image.image' => 'El archivo tiene que ser una imagen.',
                'image.mimes' => 'La imagen debe ser jpeg, jpg, png, gif o webp.',
                'image.max' => 'La imagen no puede superar los 5 MB.',
            ]
        );

        Photo::create([
            'title' => $data['title'],
            'path' => $request->file('image')->store('photos', 'public'),
        ]);

        return redirect()->route('photos.index')->with('ok', 'La imagen se ha subido correctamente.');
    }

    public function update(Request $request, Photo $photo)
    {
        $request->validate(
            [
                'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
            ],
            [
                'image.required' => 'Tienes que seleccionar una imagen.',
                'image.image' => 'El archivo tiene que ser una imagen.',
                'image.mimes' => 'La imagen debe ser jpeg, jpg, png, gif o webp.',
                'image.max' => 'La imagen no puede superar los 5 MB.',
            ]
        );

        if ($photo->path) {
            Storage::disk('public')->delete($photo->path);
        }

        $photo->update([
            'path' => $request->file('image')->store('photos', 'public'),
        ]);

        return redirect()->route('photos.index')->with('ok', 'La imagen se ha reemplazado correctamente.');
    }

    public function destroy(Photo $photo)
    {
        if ($photo->path) {
            Storage::disk('public')->delete($photo->path);
        }

        $photo->delete();

        return redirect()->route('photos.index')->with('ok', 'La imagen se ha eliminado correctamente.');
    }
}
