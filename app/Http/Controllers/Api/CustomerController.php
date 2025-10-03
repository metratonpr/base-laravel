<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class, 'customer');
    }

    public function index(Request $request): JsonResponse
    {
        $customers = Customer::query()
            ->with('municipality.state')
            ->when($request->filled('municipality_id'), fn ($query) => $query->where('municipality_id', $request->integer('municipality_id')))
            ->when($request->filled('state_id'), fn ($query) => $query->whereHas('municipality', fn ($sub) => $sub->where('state_id', $request->integer('state_id'))))
            ->when($request->filled('document'), fn ($query) => $query->where('document', preg_replace('/\D/', '', (string) $request->input('document'))))
            ->orderBy('nome')
            ->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return $this->successResponse([
            'items' => CustomerResource::collection($customers->getCollection()),
            'meta' => $this->paginationMeta($customers),
        ], 'Lista de clientes obtida com sucesso.');
    }

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->validated())->load('municipality.state');

        return $this->successResponse(CustomerResource::make($customer), 'Cliente criado com sucesso.', 201);
    }

    public function show(Customer $customer): JsonResponse
    {
        return $this->successResponse(CustomerResource::make($customer->loadMissing('municipality.state')), 'Cliente localizado com sucesso.');
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): JsonResponse
    {
        $customer->update($request->validated());

        return $this->successResponse(CustomerResource::make($customer->load('municipality.state')), 'Cliente atualizado com sucesso.');
    }

    public function destroy(Customer $customer): JsonResponse
    {
        return $this->deleteModel(fn () => $customer->delete(), 'Cliente removido com sucesso.');
    }
}
