<?php

use App\Config\Router;
use App\Config\Auth;
use App\Config\Container;
use App\Config\DependencyProvider;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RecuperarSenha\RecuperarSenhaController;
use App\Http\Controllers\Endereco\EnderecoController;
use App\Http\Controllers\Livro\LivroController;
use App\Http\Controllers\Categoria\CategoriaController;
use App\Http\Controllers\Troca\TrocaController;


$router = new Router();
$auth = new Auth();
$container = new Container();
$dependencyProvider = new DependencyProvider($container);
$dependencyProvider->register();

$authController = $container->get(AuthController::class);
$userController = $container->get(UserController::class);
$recuperarSenhaController = $container->get(RecuperarSenhaController::class);
$enderecoController = $container->get(EnderecoController::class);
$livroController = $container->get(LivroController::class);
$categoriaController = $container->get(CategoriaController::class);
$trocaController = $container->get(TrocaController::class);

// - Rotas

//autenticacao
$router->create("POST", "/auth", [$authController, 'login'], null);
$router->create("POST", "/google-auth", [$authController, 'loginWithGoogle'], null);
$router->create("GET", "/google-link", [$authController, 'generateGoogleAuthLink'], null);
$router->create("GET", "/me", [$authController, 'profile'], $auth);

//usuarios
$router->create("GET", "/usuarios", [$userController, 'index'], $auth);
$router->create("POST", "/usuarios", [$userController, 'store'], null);
$router->create("PUT", "/usuarios/{uuid}", [$userController, 'update'], $auth);
$router->create("PATCH", "/usuarios/{uuid}/password", [$userController, 'updatePassword'], $auth);
$router->create("POST", "/usuarios/{uuid}/icon", [$userController, 'updateIcon'], $auth);
$router->create("DELETE", "/usuarios/{uuid}", [$userController, 'destroy'], $auth);

//recuperar-senha   
$router->create("POST", "/recuperar-senha/enviar-codigo", [$recuperarSenhaController, 'sendVerificationCode'], null);
$router->create("PUT", "/recuperar-senha", [$recuperarSenhaController, 'changePassword'], null);

//enderecos
$router->create("GET", "/enderecos", [$enderecoController, 'index'], $auth);
$router->create("POST", "/enderecos", [$enderecoController, 'store'], $auth);
$router->create("PUT", "/enderecos/{uuid}", [$enderecoController, 'update'], $auth);
$router->create("DELETE", "/enderecos/{uuid}", [$enderecoController, 'destroy'], $auth);

//livros
$router->create("GET", "/livros", [$livroController, 'index'], $auth);
$router->create("GET", "/livros/user/{uuid}", [$livroController, 'getUserBooks'], $auth);
$router->create("GET", "/public/img/livros/{imagem}", [$livroController, 'readImage'], null);
$router->create("POST", "/livros", [$livroController, 'store'], $auth);
$router->create("POST", "/livros/{uuid}/imagem", [$livroController, 'updateImage'], $auth);
$router->create("PUT", "/livros/{uuid}", [$livroController, 'update'], $auth);
$router->create("DELETE", "/livros/{uuid}", [$livroController, 'destroy'], $auth);

//categorias
$router->create("GET", "/categorias", [$categoriaController, 'index'], $auth);
$router->create("POST", "/categorias", [$categoriaController, 'store'], $auth);
$router->create("PUT", "/categorias/{uuid}", [$categoriaController, 'update'], $auth);
$router->create("DELETE", "/categorias/{uuid}", [$categoriaController, 'destroy'], $auth);

//trocas
$router->create("GET", "/trocas", [$trocaController, 'index'], $auth);
$router->create("POST", "/trocas", [$trocaController, 'store'], $auth);
$router->create("PUT", "/trocas/{uuid}", [$trocaController, 'update'], $auth);
$router->create("DELETE", "/trocas/{uuid}", [$trocaController, 'destroy'], $auth);


return $router;