<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Group::class, 'group');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $groups = Group::query()->orderBy('name')->paginate();

        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupRequest $request): JsonResponse
    {
        $group = Group::create($request->validated());

        return GroupResource::make($group)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group): GroupResource
    {
        return GroupResource::make($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupRequest $request, Group $group): GroupResource
    {
        $group->update($request->validated());

        return GroupResource::make($group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group): JsonResponse
    {
        $group->delete();

        return response()->json(null, 204);
    }
}
