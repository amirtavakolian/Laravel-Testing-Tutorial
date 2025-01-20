<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function test_user_register_validation()
    {
        $user = User::factory()->state(['is_admin' => 1])->make()->toArray();

        $user['password'] = Hash::make('password');

        $response = $this->post(route('auth.register'), $user);

        $response->assertValid();

        $response->assertSessionDoesntHaveErrors();
    }

    public function test_user_registration_fails_when_required_data_is_missing()
    {
        $user = User::factory()->make()->toArray();

        $response = $this->post(route('auth.register'), $user);

        $response->assertInvalid(['is_admin', 'password']);

        $response->assertSessionHasErrors();
    }
}
