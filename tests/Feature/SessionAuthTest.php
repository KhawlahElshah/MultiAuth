<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function guest_can_register_successfully()
    {
        $user = factory('App\User')->make();

        $this->post(
            '/register',

            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password'
            ]

        )
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect('/home');

        $this->assertDatabaseHas('users', ['name' => $user->name, 'email' => $user->email]);
    }

    /**
     *@test
     */
    function existing_user_can_login_successfully()
    {
        $user = factory('App\User')->create();

        $this->post(
            '/login',
            ['email' => $user->email, 'password' => 'password']
        )
            ->assertRedirect('/home');
    }

    /**
     *@test
     */
    function unexisting_user_can_not_login()
    {
        $this->post(
            '/login',
            ['email' => 'guest@guest.com', 'password' => 'password']
        )
            ->assertSessionHasErrors();
    }
}
