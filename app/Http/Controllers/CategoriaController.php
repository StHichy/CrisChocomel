<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:categorias,nome',
        ], [
            'nome.unique' => 'Essa categoria já existe.',
        ]);

        Categoria::create([
            'nome' => $request->nome,
            'slug' => Str::slug($request->nome),
        ]);

        return back()->with('success', "Categoria \"{$request->nome}\" criada com sucesso!");
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return back()->with('success', 'Categoria removida!');
    }
}