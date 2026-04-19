<?php

namespace App\Infra\Persistence\Troca;

use App\Domain\Models\Troca\Troca;
use App\Domain\Repositories\Troca\TrocaRepositoryInterface;
use App\Infra\Persistence\BaseRepository;

class TrocaRepository extends BaseRepository implements TrocaRepositoryInterface {

    public static $className = Troca::class;

    public function __construct() {
        parent::__construct();
        $this->model = new Troca();
    }

}