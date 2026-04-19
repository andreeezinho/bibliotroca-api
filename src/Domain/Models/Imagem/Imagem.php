<?php

namespace App\Domain\Models\Imagem;

use App\Domain\Models\Traits\ModelTrait;

class Imagem {

    use ModelTrait;

    public const TABLE = 'imagens';

    public int $id;
    public ?string $uuid;
    public int $livros_id;
    public string $imagem;
    public int $ativo;
    public ?string $created_at;
    public ?string $updated_at;

    public function create(array $data) : Imagem {
        $imagem = new Imagem();
        $imagem->setFields($data);
        $imagem->uuid = $data['uuid'] ?? $this->generateUUID();
        return $imagem;
    }

}