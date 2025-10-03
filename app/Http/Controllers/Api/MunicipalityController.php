<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Http\Resources\MunicipalityResource;
use App\Models\Municipality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Municipality::class, 'municipality');
    }

    public function index(Request $request): JsonResponse
    {
        $municipalities = Municipality::query()
            ->with('state')
            ->when($request->filled('state_id'), fn ($query) => $query->where('state_id', $request->integer('state_id')))
            ->when($request->filled('state_abbreviation'), function ($query) use ($request) {
                $sigla = strtoupper((string) $request->input('state_abbreviation'));
                $query->whereHas('state', fn ($stateQuery) => $stateQuery->where('abbreviation', $sigla));
            })
            ->orderBy('name')
            ->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return $this->successResponse([
            'items' => MunicipalityResource::collection($municipalities->getCollection()),
            'meta' => $this->paginationMeta($municipalities),
        ], 'Lista de munic?pios obtida com sucesso.');
    }

    public function store(StoreMunicipalityRequest $request): JsonResponse
    {
        $municipality = Municipality::create($request->validated())->load('state');

        return $this->successResponse(MunicipalityResource::make($municipality), 'Munic?pio criado com sucesso.', 201);
    }

    public function show(Municipality $municipality): JsonResponse
    {
        return $this->successResponse(MunicipalityResource::make($municipality->loadMissing('state')), 'Munic?pio localizado com sucesso.');
    }

    public function update(UpdateMunicipalityRequest $request, Municipality $municipality): JsonResponse
    {
        $municipality->update($request->validated());

        return $this->successResponse(MunicipalityResource::make($municipality->load('state')), 'Munic?pio atualizado com sucesso.');
    }

    public function destroy(Municipality $municipality): JsonResponse
    {
        if ($municipality->companies()->exists() || $municipality->customers()->exists()) {
            return $this->errorResponse('N?o ? poss?vel remover o munic?pio porque existem empresas ou clientes vinculados.', null, 409);
        }

        return $this->deleteModel(fn () => $municipality->delete(), 'Munic?pio removido com sucesso.');
    }
}
