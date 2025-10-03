<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $companies = Company::query()
            ->with('municipality.state')
            ->when($request->filled('municipality_id'), fn ($query) => $query->where('municipality_id', $request->integer('municipality_id')))
            ->when($request->filled('state_id'), fn ($query) => $query->whereHas('municipality', fn ($sub) => $sub->where('state_id', $request->integer('state_id'))))
            ->orderBy('razao_social')
            ->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return CompanyResource::collection($companies);
    }

    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = Company::create($request->validated())->load('municipality.state');

        return CompanyResource::make($company)
            ->response()
            ->setStatusCode(201);
    }

    public function show(Company $company): CompanyResource
    {
        return CompanyResource::make($company->loadMissing('municipality.state'));
    }

    public function update(UpdateCompanyRequest $request, Company $company): CompanyResource
    {
        $company->update($request->validated());

        return CompanyResource::make($company->load('municipality.state'));
    }

    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json(null, 204);
    }
}
