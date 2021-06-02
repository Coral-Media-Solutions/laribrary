<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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
     * @param Request $request
     * @return JsonResource
     */
    public function store(Request $request): JsonResource
    {
        $data = $request->validate([
            'name'=>'required|string|unique:users',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

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
     * @param Request $request
     * @param User $user
     * @return JsonResource
     */
    public function update(Request $request, User $user): JsonResource
    {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email',
            'password'=>'min:8'
        ]);

        $user->update($data);

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
