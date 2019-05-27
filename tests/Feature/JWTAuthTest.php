<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;

class JWTAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function guest_can_register_successfully()
    {
        $user = factory('App\User')->make();

        $this->json(
            'POST',
            '/api/register',
            array_merge($user->toArray(), ['password' => 'password'])
        )
            ->assertJsonMissingValidationErrors()
            ->assertJsonStructure(['token', 'token_type']);

        $this->assertDatabaseHas('users', ['name' => $user->name, 'email' => $user->email]);
    }

    /**
     *@test
     */
    function existing_user_can_login_successfully()
    {
        $user = factory('App\User')->create();

        $this->json(
            'POST',
            '/api/login',
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertJsonStructure(['token', 'token_type']);
    }

    /**
     *@test
     */
    function user_can_show_his_profile()
    {
        $user = factory('App\User')->create();
        $token = JWTAuth::attempt(['email' => $user->email, 'password' => 'password']);

        $this->json(
            'GET',
            '/api/user',
            [],
            ['Authorization' => 'bearer ' . $token]
        )
            ->assertExactJson($user->toArray());
    }
}
