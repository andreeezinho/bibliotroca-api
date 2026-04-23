<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use App\Http\Request\Request;
use App\Http\Transformer\Categoria\CategoriaTransformer;
use App\Domain\Repositories\Categoria\CategoriaRepositoryInterface;

class CategoriaController extends Controller {

    protected $categoriaRepository;

    public function __construct(CategoriaRepositoryInterface $categoriaRepository){
        $this->categoriaRepository = $categoriaRepository;
    }

    public function index(Request $request){
        $params = $request->all();

        $categorias = $this->categoriaRepository->all($params);

        return $this->respJson([
            'message' => 'Categorias listadas',
            'data' => CategoriaTransformer::transformArray($categorias)
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $validate = $this->validate($data, [
            'nome' => 'required|string|max:255',
            'ativo' => 'max:1'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $categoria = $this->categoriaRepository->create($data);

        if(is_null($categoria)){
            return $this->respJson([
                'message' => 'Não foi possível cadastrar categoria'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Cadastro realizado com sucesso',
            'data' => CategoriaTransformer::transform($categoria)
        ], 201);
    }

    public function update(Request $request, $uuid){
        $data = $request->all();

        $categoria = $this->categoriaRepository->findBy('uuid', $uuid);

        if(is_null($categoria)){
            return $this->respJson([
                'message' => 'Categoria não encontrada'
            ], 422);
        }

        $validate = $this->validate($data, [
            'nome' => 'required|string|max:255',
            'ativo' => 'max:1'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $categoria = $this->categoriaRepository->update($data, $categoria->id);

        if(is_null($categoria)){
            return $this->respJson([
                'message' => 'Não foi possível atualizar categoria'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Sucesso ao atualizar categoria',
            'data' => CategoriaTransformer::transform($categoria)
        ], 201);
    }

    public function destroy(Request $request, $uuid){
        $categoria = $this->categoriaRepository->findBy('uuid', $uuid);

        if(is_null($categoria)){
            return $this->respJson([
                'message' => 'Categoria não encontrada'
            ], 422);
        }

        $categoria = $this->categoriaRepository->delete($categoria->id);

        if(!$categoria){
            return $this->respJson([
                'message' => 'Não foi possível deletar categoria'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Categoria deletada'
        ], 201);
    }

}