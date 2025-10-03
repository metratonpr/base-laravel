<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    public function index(Request $request): JsonResponse
    {
        $companies = Company::query()
            ->with('municipality.state')
            ->when($request->filled('municipality_id'), fn ($query) => $query->where('municipality_id', $request->integer('municipality_id')))
            ->when($request->filled('state_id'), fn ($query) => $query->whereHas('municipality', fn ($sub) => $sub->where('state_id', $request->integer('state_id'))))
            ->orderBy('razao_social')
            ->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return $this->successResponse([
            'items' => CompanyResource::collection($companies->getCollection()),
            'meta' => $this->paginationMeta($companies),
        ], 'Lista de empresas obtida com sucesso.');
    }

    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = Company::create($request->validated())->load('municipality.state');

        return $this->successResponse(CompanyResource::make($company), 'Empresa criada com sucesso.', 201);
    }

    public function show(Company $company): JsonResponse
    {
        return $this->successResponse(CompanyResource::make($company->loadMissing('municipality.state')), 'Empresa localizada com sucesso.');
    }

    public function update(UpdateCompanyRequest $request, Company $company): JsonResponse
    {
        $company->update($request->validated());

        return $this->successResponse(CompanyResource::make($company->load('municipality.state')), 'Empresa atualizada com sucesso.');
    }

    public function destroy(Company $company): JsonResponse
    {
        return $this->deleteModel(fn () => $company->delete(), 'Empresa removida com sucesso.');
    }
}
