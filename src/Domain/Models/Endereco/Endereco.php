<?php

namespace App\Domain\Models\Endereco;

use App\Domain\Models\Traits\ModelTrait;

class Endereco {

    use ModelTrait;

    public const TABLE = 'enderecos';

    public int $id;
    public ?string $uuid;
    public string $cep;
    public string $rua;
    public string $bairro;
    public string $numero;
    public ?string $complemento;
    public int $usuarios_id;
    public int $ativo;
    public ?string $created_at;
    public ?string $updated_at;

    public function create(array $data) : Endereco {
        $endereco = new Endereco();
        $endereco->setFields($data);
        $endereco->uuid = $data['uuid'] ?? $this->generateUUID();
        return $endereco;
    }

}