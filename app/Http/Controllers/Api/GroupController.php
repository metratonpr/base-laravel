<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Group::class, 'group');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $groups = Group::query()
            ->orderBy('name')
            ->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return $this->successResponse([
            'items' => GroupResource::collection($groups->getCollection()),
            'meta' => $this->paginationMeta($groups),
        ], 'Lista de grupos obtida com sucesso.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupRequest $request): JsonResponse
    {
        $group = Group::create($request->validated());

        return $this->successResponse(GroupResource::make($group), 'Grupo criado com sucesso.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group): JsonResponse
    {
        return $this->successResponse(GroupResource::make($group), 'Grupo localizado com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupRequest $request, Group $group): JsonResponse
    {
        $group->update($request->validated());

        return $this->successResponse(GroupResource::make($group), 'Grupo atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group): JsonResponse
    {
        return $this->deleteModel(fn () => $group->delete(), 'Grupo removido com sucesso.');
    }
}
