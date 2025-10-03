<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class, 'customer');
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $customers = Customer::query()
            ->with('municipality.state')
            ->when($request->filled('municipality_id'), fn ($query) => $query->where('municipality_id', $request->integer('municipality_id')))
            ->when($request->filled('state_id'), fn ($query) => $query->whereHas('municipality', fn ($sub) => $sub->where('state_id', $request->integer('state_id'))))
            ->when($request->filled('document'), fn ($query) => $query->where('document', preg_replace('/\D/', '', (string) $request->input('document'))))
            ->orderBy('nome')
            ->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return CustomerResource::collection($customers);
    }

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->validated())->load('municipality.state');

        return CustomerResource::make($customer)
            ->response()
            ->setStatusCode(201);
    }

    public function show(Customer $customer): CustomerResource
    {
        return CustomerResource::make($customer->loadMissing('municipality.state'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): CustomerResource
    {
        $customer->update($request->validated());

        return CustomerResource::make($customer->load('municipality.state'));
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json(null, 204);
    }
}
