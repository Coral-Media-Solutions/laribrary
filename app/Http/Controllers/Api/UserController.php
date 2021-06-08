<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return JsonResource
     */
    public function store(UserStoreRequest $request): JsonResource
    {
        $user = User::create($request->validated());

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResource
     */
    public function show(User $user): JsonResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return JsonResource
     */
    public function update(UserUpdateRequest $request, User $user): JsonResource
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
