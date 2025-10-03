<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Http\Resources\MunicipalityResource;
use App\Models\Municipality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MunicipalityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Municipality::class, 'municipality');
    }

    public function index(Request $request): AnonymousResourceCollection
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

        return MunicipalityResource::collection($municipalities);
    }

    public function store(StoreMunicipalityRequest $request): JsonResponse
    {
        $municipality = Municipality::create($request->validated())->load('state');

        return MunicipalityResource::make($municipality)
            ->response()
            ->setStatusCode(201);
    }

    public function show(Municipality $municipality): MunicipalityResource
    {
        return MunicipalityResource::make($municipality->loadMissing('state'));
    }

    public function update(UpdateMunicipalityRequest $request, Municipality $municipality): MunicipalityResource
    {
        $municipality->update($request->validated());

        return MunicipalityResource::make($municipality->load('state'));
    }

    public function destroy(Municipality $municipality): JsonResponse
    {
        $municipality->delete();

        return response()->json(null, 204);
    }
}
