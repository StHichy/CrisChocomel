<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * Retorna a URL pública correta do Supabase para exibição no navegador.
     */
    public function getImagemAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        // Se já for uma URL completa, retorna ela mesma
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Monta a URL pública padrão do Supabase (object/public)
        return "https://knwaqlmmlvapbjntsftp.supabase.co/storage/v1/object/public/produtos/" . $value;
    }
}