<?php

namespace App\Infra\Persistence\Imagem;

use App\Domain\Models\Imagem\Imagem;
use App\Domain\Repositories\Imagem\ImagemRepositoryInterface;
use App\Infra\Persistence\BaseRepository;

class ImagemRepository extends BaseRepository implements ImagemRepositoryInterface {

    public static $className = Imagem::class;

    public function __construct() {
        parent::__construct();
        $this->model = new Imagem();
    }

}