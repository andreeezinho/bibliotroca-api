<?php

namespace App\Infra\Persistence\Categoria;

use App\Domain\Models\Categoria\Categoria;
use App\Domain\Repositories\Categoria\CategoriaRepositoryInterface;
use App\Infra\Persistence\BaseRepository;

class CategoriaRepository extends BaseRepository implements CategoriaRepositoryInterface {

    public static $className = Categoria::class;

    public function __construct() {
        parent::__construct();
        $this->model = new Categoria();
    }

}