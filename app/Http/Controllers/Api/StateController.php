<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StateController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(State::class, 'state');
    }

    public function index(): AnonymousResourceCollection
    {
        $states = State::query()->orderBy('name')->get();

        return StateResource::collection($states);
    }

    public function store(StoreStateRequest $request): JsonResponse
    {
        $state = State::create($request->validated());

        return StateResource::make($state)
            ->response()
            ->setStatusCode(201);
    }

    public function show(State $state): StateResource
    {
        return StateResource::make($state);
    }

    public function update(UpdateStateRequest $request, State $state): StateResource
    {
        $state->update($request->validated());

        return StateResource::make($state);
    }

    public function destroy(State $state): JsonResponse
    {
        $state->delete();

        return response()->json(null, 204);
    }
}
