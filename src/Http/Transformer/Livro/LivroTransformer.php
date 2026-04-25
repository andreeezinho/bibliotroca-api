<?php

namespace App\Http\Transformer\Livro;

use App\Domain\Models\Livro\Livro;

class LivroTransformer {

    public static function transform(Livro $data) : array {
        return [
            'uuid' => $data->uuid,
            'titulo' => $data->titulo,
            'autor' => $data->autor,
            'paginas' => $data->paginas,
            'categorias_id' => $data->categorias_id,
            'descricao' => $data->descricao,
            'estado' => $data->estado,
            'imagem' => $data->imagem,
            'usuarios_id' => $data->usuarios_id,
            'ativo' => $data->ativo,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public static function transformArray(array $produtos) : array {
        return array_map(function(Livro $data) {
            return self::transform($data);
        }, $produtos);
    }

}