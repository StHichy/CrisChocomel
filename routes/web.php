<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CategoriaController;



Route::get('/', [ProdutoController::class, 'home'])->name('index');
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos');
Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho');
Route::post('/carrinho/adicionar/{id}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::post('/carrinho/atualizar/{id}', [CarrinhoController::class, 'atualizar'])->name('carrinho.atualizar');
Route::post('/carrinho/remover/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
Route::post('/carrinho/cupom', [CarrinhoController::class, 'cupom'])->name('carrinho.cupom');
Route::post('/carrinho/finalizar', [CarrinhoController::class, 'finalizar'])->name('carrinho.finalizar');
Route::view('/sobre', 'sobre')->name('sobre');
Route::get('/dashboard', function () {
    return view('dashboard');
    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Rotas do Administrador
// Rotas do Administrador
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::delete('/admin/categorias/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::get('/admin/produtos', [ProdutoController::class, 'adminIndex'])->name('admin.produtos');
    Route::patch('/admin/produtos/{id}/toggle', [ProdutoController::class, 'toggleAtivo'])->name('produtos.toggle');
    Route::get('/produtos/novo', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/produtos/{id}/editar', [ProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{id}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
});
require __DIR__.'/auth.php';
