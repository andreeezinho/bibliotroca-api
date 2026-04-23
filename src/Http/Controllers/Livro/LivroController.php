<?php

namespace App\Http\Controllers\Livro;

use App\Http\Controllers\Controller;
use App\Http\Request\Request;
use App\Http\Transformer\Livro\LivroTransformer;
use App\Domain\Repositories\Livro\LivroRepositoryInterface;
use App\Domain\Repositories\Categoria\CategoriaRepositoryInterface;
use App\Infra\Services\JWT\JWT;
use App\Infra\Services\File\FileService;

class LivroController extends Controller {

    protected $livroRepository;
    protected $categoriaRepository;
    protected $fileService;

    public function __construct(LivroRepositoryInterface $livroRepository, CategoriaRepositoryInterface $categoriaRepository, FileService $fileService){
        $this->livroRepository = $livroRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->fileService = $fileService;
    }

    public function index(Request $request){
        $params = $request->all();

        $livros = $this->livroRepository->all($params);

        return $this->respJson([
            'message' => 'Livros listados',
            'data' => LivroTransformer::transformArray($livros)
        ]);
    }

    public function store(Request $request){
        $user = JWT::validateToken($request->getHeaders('Authorization'));  

        $data = $request->all();

        $categoria = $this->categoriaRepository->findBy('uuid', $data['categoria_uuid']);

        if(is_null($categoria)){
            return $this->respJson([
                'message' => 'Categoria não encontrada'
            ], 422);
        }

        $validate = $this->validate($data, [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'paginas' => 'required|int',
            'estado' => 'required|string|max:255',
            'ativo' => 'max:1'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $image = $request->getFileParams();

        $image = $this->fileService->uploadFile($data['imagem'], '/img/livros');

        $data = array_merge(['categorias_id' => $categoria->id, 'usuarios_id' => $user['id']], $data);

        $livro = $this->livroRepository->create($data);

        if(is_null($livro)){
            return $this->respJson([
                'message' => 'Não foi possível cadastrar livro'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Cadastro realizado com sucesso',
            'data' => LivroTransformer::transform($livro)
        ], 201);
    }

    public function update(Request $request, $uuid){
        $data = $request->all();

        $livro = $this->livroRepository->findBy('uuid', $uuid);

        if(is_null($livro)){
            return $this->respJson([
                'message' => 'Livro não encontrado'
            ], 422);
        }

        $validate = $this->validate($data, [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'paginas' => 'required|int',
            'estado' => 'required|string|max:255',
            'ativo' => 'max:1'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $livro = $this->livroRepository->update($data, $livro->id);

        if(is_null($livro)){
            return $this->respJson([
                'message' => 'Não foi possível atualizar livro'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Sucesso ao atualizar livro',
            'data' => LivroTransformer::transform($livro)
        ], 201);
    }

    public function destroy(Request $request, $uuid){
        $livro = $this->livroRepository->findBy('uuid', $uuid);

        if(is_null($livro)){
            return $this->respJson([
                'message' => 'Livro não encontrado'
            ], 422);
        }

        $livro = $this->livroRepository->delete($livro->id);

        if(!$livro){
            return $this->respJson([
                'message' => 'Não foi possível deletar livro'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Livro deletado'
        ], 201);
    }

}