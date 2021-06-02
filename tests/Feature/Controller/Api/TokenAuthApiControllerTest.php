<?php

namespace Tests\Feature\Controller\Api;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TokenAuthApiControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTokenAction()
    {
        $response = $this->json(
            Request::METHOD_POST,'/api/token',
            [
                'name' => 'test',
                'email' => 'test@example.com',
                'password' => 'test@2021',
            ]
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(
                fn (AssertableJson $json) =>
                    $json->where('type', 'Bearer')
                        ->where('success', true)
                        ->missing('password')->etc()
            )
        ;
    }

    public function testRevokeTokenAction()
    {
        Sanctum::actingAs($this->user, ['*']);

        $response = $this->json(
            Request::METHOD_GET,'/api/token/revoke',
            []
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(
                fn (AssertableJson $json) => $json->where('success', true)->etc()
            )
        ;
    }

    public function testCurrentUser()
    {
        Sanctum::actingAs($this->user, ['*']);

        $response = $this->json(
            Request::METHOD_GET,'/api/user',
            []
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('name', 'test')
                    ->where('email', 'test@example.com')
                    ->etc()
            )
        ;
    }
}
