<?php

namespace App\Config;

use App\Domain\Repositories\User\UserRepositoryInterface;
use App\Infra\Persistence\User\UserRepository;
use App\Domain\Repositories\RecuperarSenha\RecuperarSenhaRepositoryInterface;
use App\Infra\Persistence\RecuperarSenha\RecuperarSenhaRepository;
use App\Domain\Repositories\Categoria\CategoriaRepositoryInterface;
use App\Infra\Persistence\Categoria\CategoriaRepository;
use App\Domain\Repositories\Endereco\EnderecoRepositoryInterface;
use App\Infra\Persistence\Endereco\EnderecoRepository;
use App\Domain\Repositories\Livro\LivroRepositoryInterface;
use App\Infra\Persistence\Livro\LivroRepository;
use App\Domain\Repositories\Troca\TrocaRepositoryInterface;
use App\Infra\Persistence\Troca\TrocaRepository;

class DependencyProvider {

    private $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function register(){

        $this->container
            ->set(
                UserRepositoryInterface::class,
                new UserRepository()
            );

        $this->container
            ->set(
                RecuperarSenhaRepositoryInterface::class,
                new RecuperarSenhaRepository()
            );

        $this->container
            ->set(
                CategoriaRepositoryInterface::class,
                new CategoriaRepository()
            );

        $this->container
            ->set(
                EnderecoRepositoryInterface::class,
                new EnderecoRepository()
            );

        $this->container
            ->set(
                LivroRepositoryInterface::class,
                new LivroRepository()
            );

        $this->container
            ->set(
                TrocaRepositoryInterface::class,
                new TrocaRepository()
            );

    }

}