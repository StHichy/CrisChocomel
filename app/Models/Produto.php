<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'imagem',
        'categoria',
        'destaque',
        'ativo',
    ];

    /**
     * Retorna a URL da imagem de forma segura, evitando erros de S3 vazio.
     */
    public function getImagemAttribute($value)
    {
        // Se estiver vazio, retorna null
        if (empty($value)) {
            return null;
        }

        // Se já for uma URL completa (ex: link direto do Supabase), retorna ela
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Caso seja apenas o caminho relativo, gera a URL pública com segurança
        return Storage::disk('s3')->url($value);
    }
}