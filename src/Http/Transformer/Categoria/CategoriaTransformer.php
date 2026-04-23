<?php

namespace App\Http\Transformer\Categoria;

use App\Domain\Models\Categoria\Categoria;

class CategoriaTransformer {

    public static function transform(Categoria $data) : array {
        return [
            'uuid' => $data->uuid,
            'nome' => $data->nome,
            'ativo' => $data->ativo,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public static function transformArray(array $produtos) : array {
        return array_map(function(Categoria $data) {
            return self::transform($data);
        }, $produtos);
    }

}