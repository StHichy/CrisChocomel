<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Categoria;

class ProdutoController extends Controller
{
    // Vitrine Home (apenas ativos e em destaque)
    public function home()
{
    $produtosDestaque = Produto::where('ativo', true)
        ->where('destaque', true)
        ->get();

    $categorias = Categoria::orderBy('nome')->get();

    return view('index', compact('produtosDestaque', 'categorias'));
}
    // Vitrine Pública de Produtos (apenas ativos)
    public function index(Request $request)
{
    $query = Produto::where('ativo', true);

    if ($request->filled('categoria')) {
        $query->where('categoria', $request->categoria);
    }

    if ($request->filled('busca')) {
        $busca = $request->busca;
        $query->where(function ($q) use ($busca) {
            $q->where('nome', 'like', "%{$busca}%")
              ->orWhere('descricao', 'like', "%{$busca}%");
        });
    }

    switch ($request->ordem) {
        case 'asc':  $query->orderBy('preco', 'asc'); break;
        case 'desc': $query->orderBy('preco', 'desc'); break;
        case 'az':   $query->orderBy('nome', 'asc'); break;
        default:     $query->orderBy('destaque', 'desc')->latest(); break;
    }

    $produtos = $query->get();
    $categorias = Categoria::orderBy('nome')->get();

    return view('produtos', compact('produtos', 'categorias'));
}

    // Painel exclusivo do Admin (mostra ATIVOS e INATIVOS)
   public function adminIndex(Request $request)
{
    $query = Produto::query();

    if ($request->status === 'ativos') {
        $query->where('ativo', true);
    } elseif ($request->status === 'inativos') {
        $query->where('ativo', false);
    }

    if ($request->filled('busca')) {
        $query->where('nome', 'like', "%{$request->busca}%");
    }

    $produtos = $query->orderBy('ativo', 'desc')->latest()->get();
    $categorias = Categoria::orderBy('nome')->get();

    return view('admin.produtos', compact('produtos', 'categorias'));
}
   

    public function create()
{
    $categorias = Categoria::orderBy('nome')->get();
    return view('produtos-create', compact('categorias'));
}

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco'     => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:100',
            'imagem'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
    // Apaga a imagem antiga ao editar, se existir
    if (isset($produto) && $produto->imagem) {
        $caminhoAntigo = public_path($produto->imagem);
        if (File::exists($caminhoAntigo)) {
            File::delete($caminhoAntigo);
        }
    }

    // Salva em storage/app/public/produtos e retorna 'produtos/arquivo.jpg'
    $caminho = $request->file('imagem')->store('produtos', 'public');
    $dados['imagem'] = 'storage/' . $caminho;
}

        $dados['destaque'] = $request->has('destaque');
        $dados['ativo'] = $request->has('ativo') ? true : true; // Ativo por padrão ao criar

        Produto::create($dados);

        return redirect()->route('admin.produtos')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
{
    $produto = Produto::findOrFail($id);
    $categorias = Categoria::orderBy('nome')->get();
    return view('produtos-edit', compact('produto', 'categorias'));
}

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $dados = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco'     => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:100',
            'imagem'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
    // Apaga a imagem antiga ao editar, se existir
    if (isset($produto) && $produto->imagem) {
        $caminhoAntigo = public_path($produto->imagem);
        if (File::exists($caminhoAntigo)) {
            File::delete($caminhoAntigo);
        }
    }

    // Salva em storage/app/public/produtos e retorna 'produtos/arquivo.jpg'
    $caminho = $request->file('imagem')->store('produtos', 'public');
    $dados['imagem'] = 'storage/' . $caminho;
}

        $dados['destaque'] = $request->has('destaque');
        $dados['ativo'] = $request->has('ativo');

        $produto->update($dados);

        return redirect()->route('admin.produtos')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        if ($produto->imagem && File::exists(public_path($produto->imagem))) {
            File::delete(public_path($produto->imagem));
        }

        $produto->delete();

        return redirect()->route('admin.produtos')->with('success', 'Produto excluído com sucesso!');
    }
     public function toggleAtivo($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->ativo = !$produto->ativo;
        $produto->save();

        $statusTexto = $produto->ativo ? 'ativado' : 'inativado';

        return back()->with('success', "Produto \"{$produto->nome}\" {$statusTexto} com sucesso!");
    }
}