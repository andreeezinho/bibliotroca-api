<?php

namespace App\Domain\Models\Categoria;

use App\Domain\Models\Traits\ModelTrait;

class Categoria {

    use ModelTrait;

    public const TABLE = 'categorias';

    public int $id;
    public ?string $uuid;
    public string $nome;
    public int $ativo;
    public ?string $created_at;
    public ?string $updated_at;

    public function create(array $data) : Categoria {
        $categoria = new Categoria();
        $categoria->setFields($data);
        $categoria->uuid = $data['uuid'] ?? $this->generateUUID();
        return $categoria;
    }

}