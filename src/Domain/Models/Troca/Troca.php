<?php

namespace App\Domain\Models\Troca;

use App\Domain\Models\Traits\ModelTrait;

class Troca {

    use ModelTrait;

    public const TABLE = 'trocas';

    public int $id;
    public ?string $uuid;
    public int $livros_id;
    public int $dono_id;
    public int $usuarios_id;
    public string $situacao;
    public int $dono_confirmacao;
    public int $usuario_confirmacao;
    public ?string $created_at;
    public ?string $updated_at;

    public function create(array $data) : Troca {
        $troca = new Troca();
        $troca->setFields($data);
        $troca->uuid = $data['uuid'] ?? $this->generateUUID();
        return $troca;
    }

}