<?php

namespace Tests\Feature\Controller\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserIndex()
    {
        Sanctum::actingAs($this->user, ['*']);

        $response = $this->json(Request::METHOD_GET, '/api/users');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->whereType('data', 'array')
                    ->etc()
            )
        ;
    }

    public function testUserStore()
    {
        Sanctum::actingAs($this->user, ['*']);

        $response = $this->json(
            Request::METHOD_POST, '/api/users',
            [
                'name' => 'test2',
                'email' => 'test2@example.com',
                'password' => 'test2@2021'
            ]
        );

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('user.id', 2)
                    ->where('user.name', 'test2')
                    ->whereType('user', 'array')
                    ->whereType('user.id', 'integer')
                    ->whereType('user.name', 'string')
                    ->etc()
            )
        ;
    }

    public function testUserShow()
    {
        Sanctum::actingAs($this->user, ['*']);

        User::factory()->create([
            'name' => 'test2',
            'email' => 'test2@example.com',
            'password' => Hash::make('test2@2021')
        ]);

        $response = $this->json(
            Request::METHOD_GET, '/api/users/2'
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('user.id', 2)
                    ->where('user.name', 'test2')
                    ->whereType('user', 'array')
                    ->whereType('user.id', 'integer')
                    ->whereType('user.name', 'string')
                    ->etc()
            )
        ;
    }

    public function testUserUpdate()
    {
        Sanctum::actingAs($this->user, ['*']);

        $response = $this->json(
            Request::METHOD_PATCH, '/api/users/1',
            [
                'name' => 'test1',
                'email' => 'test@example.com'
            ]
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('user.id', 1)
                    ->where('user.name', 'test1')
                    ->whereType('user', 'array')
                    ->whereType('user.id', 'integer')
                    ->whereType('user.name', 'string')
                    ->etc()
            )
        ;
    }

    public function testUserDestroy()
    {
        Sanctum::actingAs($this->user, ['*']);

        $response = $this->json(Request::METHOD_DELETE, '/api/users/1');

        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }
}
