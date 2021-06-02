<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    /**
     * @var User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('test@2021')
        ]);
    }
}
