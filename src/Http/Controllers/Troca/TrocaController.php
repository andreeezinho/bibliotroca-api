<?php

namespace App\Http\Controllers\Troca;

use App\Http\Controllers\Controller;
use App\Http\Request\Request;
use App\Http\Transformer\Troca\TrocaTransformer;
use App\Domain\Repositories\Troca\TrocaRepositoryInterface;

class TrocaController extends Controller {

    protected $trocaRepository;

    public function __construct(TrocaRepositoryInterface $trocaRepository){
        $this->trocaRepository = $trocaRepository;
    }

    public function index(Request $request){
        $params = $request->all();

        $trocas = $this->trocaRepository->all($params);

        return $this->respJson([
            'message' => 'Trocas listadas',
            'data' => TrocaTransformer::transformArray($trocas)
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $validate = $this->validate($data, [
            'situacao' => 'required|string',
            'dono_confirmacao' => 'required|int',
            'usuario_confirmacao' => 'required|int'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $troca = $this->trocaRepository->create($data);

        if(is_null($troca)){
            return $this->respJson([
                'message' => 'Não foi possível cadastrar troca'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Cadastro realizado com sucesso',
            'data' => TrocaTransformer::transform($troca)
        ], 201);
    }

    public function update(Request $request, $uuid){
        $data = $request->all();

        $troca = $this->trocaRepository->findBy('uuid', $uuid);

        if(is_null($troca)){
            return $this->respJson([
                'message' => 'Troca não encontrada'
            ], 422);
        }

        $validate = $this->validate($data, [
            'situacao' => 'required|string',
            'dono_confirmacao' => 'required|int',
            'usuario_confirmacao' => 'required|int'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $troca = $this->trocaRepository->update($data, $troca->id);

        if(is_null($troca)){
            return $this->respJson([
                'message' => 'Não foi possível atualizar troca'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Sucesso ao atualizar troca',
            'data' => TrocaTransformer::transform($troca)
        ], 201);
    }

    public function destroy(Request $request, $uuid){
        $troca = $this->trocaRepository->findBy('uuid', $uuid);

        if(is_null($troca)){
            return $this->respJson([
                'message' => 'Troca não encontrada'
            ], 422);
        }

        $troca = $this->trocaRepository->delete($troca->id);

        if(!$troca){
            return $this->respJson([
                'message' => 'Não foi possível deletar troca'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Troca deletada'
        ], 201);
    }

}