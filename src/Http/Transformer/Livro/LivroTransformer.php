<?php

namespace App\Http\Transformer\Livro;

use App\Domain\Models\Livro\Livro;
use App\Http\Transformer\User\UserTransformer;
use App\Infra\Persistence\User\UserRepository;

class LivroTransformer {

    protected $userRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
    }

    public function transform(Livro $data) : array {
        return [
            'uuid' => $data->uuid,
            'titulo' => $data->titulo,
            'autor' => $data->autor,
            'paginas' => $data->paginas,
            'categorias_id' => $data->categorias_id,
            'descricao' => $data->descricao,
            'estado' => $data->estado,
            'imagem' => $data->imagem,
            'usuario' => UserTransformer::transform($this->userRepository->findBy('id', $data->usuarios_id)),
            'trocado' => $data->trocado,
            'ativo' => $data->ativo,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public function transformArray(array $produtos) : array {
        return array_map(function(Livro $data) {
            return self::transform($data);
        }, $produtos);
    }

}