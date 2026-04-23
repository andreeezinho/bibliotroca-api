<?php

namespace App\Http\Transformer\Troca;

use App\Domain\Models\Troca\Troca;

class TrocaTransformer {

    public static function transform(Troca $data) : array {
        return [
            'uuid' => $data->uuid,
            'livros_id' => $data->livros_id,
            'dono_id' => $data->dono_id,
            'usuarios_id' => $data->usuarios_id,
            'situacao' => $data->situacao,
            'dono_confirmacao' => $data->dono_confirmacao,
            'usuario_confirmacao' => $data->usuario_confirmacao,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public static function transformArray(array $produtos) : array {
        return array_map(function(Troca $data) {
            return self::transform($data);
        }, $produtos);
    }

}