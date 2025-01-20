<?php

namespace Tests\Feature\Middlewares;

use App\Http\Middleware\IsAdmin;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CheckUserIsAdminMiddlewareTest extends TestCase
{

    public function test_when_user_is_admin()
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user);

        $request = Request::create('/', 'POST');

        $isAdminMiddleware = new IsAdmin();

        $response = $isAdminMiddleware->handle($request, function () {
            return new Response();
        });

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_when_user_is_not_admin()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $request = Request::create('/', 'POST');

        $isAdminMiddleware = new IsAdmin();

        $response = $isAdminMiddleware->handle($request, function () {
            return new Response();
        });

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_when_user_is_not_login()
    {
        $request = Request::create('/', 'POST');

        $isAdminMiddleware = new IsAdmin();

        $response = $isAdminMiddleware->handle($request, function () {
            return new Response();
        });

        $this->assertEquals(404, $response->getStatusCode());
    }
}
