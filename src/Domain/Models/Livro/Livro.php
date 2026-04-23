<?php

namespace App\Domain\Models\Livro;

use App\Domain\Models\Traits\ModelTrait;

class Livro {

    use ModelTrait;

    public const TABLE = 'livros';

    public int $id;
    public ?string $uuid;
    public string $titulo;
    public string $autor;
    public int $paginas;
    public int $categorias_id;
    public ?string $descricao;
    public string $estado;
    public string $imagem;
    public int $usuarios_id;
    public int $ativo;
    public ?string $created_at;
    public ?string $updated_at;

    public function create(array $data) : Livro {
        $livro = new Livro();
        $livro->setFields($data);
        $livro->uuid = $data['uuid'] ?? $this->generateUUID();
        return $livro;
    }

}