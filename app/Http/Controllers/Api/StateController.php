<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\JsonResponse;

class StateController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(State::class, 'state');
    }

    public function index(): JsonResponse
    {
        $states = State::query()->orderBy('name')->get();

        return $this->successResponse(StateResource::collection($states), 'Lista de estados obtida com sucesso.');
    }

    public function store(StoreStateRequest $request): JsonResponse
    {
        $state = State::create($request->validated());

        return $this->successResponse(StateResource::make($state), 'Estado criado com sucesso.', 201);
    }

    public function show(State $state): JsonResponse
    {
        return $this->successResponse(StateResource::make($state), 'Estado localizado com sucesso.');
    }

    public function update(UpdateStateRequest $request, State $state): JsonResponse
    {
        $state->update($request->validated());

        return $this->successResponse(StateResource::make($state), 'Estado atualizado com sucesso.');
    }

    public function destroy(State $state): JsonResponse
    {
        if ($state->municipalities()->exists()) {
            return $this->errorResponse('N?o ? poss?vel remover o estado porque existem munic?pios vinculados.', null, 409);
        }

        return $this->deleteModel(fn () => $state->delete(), 'Estado removido com sucesso.');
    }
}
