<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_method()
    {
        $post = Post::factory()->hasComments(4, [
            'user_id' => User::factory()->state(['is_admin' => 1])->create()->id,
        ])->create();

        $response = $this->get(route('posts.show', ['post' => $post]));

        $response->assertOk();

        $response->assertSeeText("Comments");

        $response->assertViewHas('post', $post);
    }

    public function test_store_post()
    {
        $post = Post::factory()->make()->toArray();

        $user = User::factory()->state(['is_admin' => 0])->create();

        $this->actingAs($user);

        $response = $this->post(route('posts.store'), $post);

        $response->assertStatus(302);

        $response->assertRedirectToRoute('home');
    }

    public function test_auth_user_can_see_comment_section_in_show_post_page()
    {
        $post = Post::factory()->create();

        $user = User::factory()->state(['is_admin' => 0])->create();

        $this->actingAs($user);

        $response = $this->get(route('posts.show', ['post' => $post]));

        $response->assertOk();

        $response->assertDontSeeText('please login for');

        $response->assertSeeInOrder([
            "<textarea name=\"content\"></textarea>"
        ], false);
    }

    public function test_not_auth_user_cant_see_comment_section_in_show_post_page()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.show', ['post' => $post]));

        $response->assertOk();

        $response->assertSeeText('please login for');

        $route = route('auth.login');

        $response->assertSee("<a href=\"$route\">Login</a>", false);
    }

    public function test_users_can_see_post_comments_in_show_post_page()
    {
        $post = Post::factory()->hasComments(5, [
            'user_id' => User::factory()->state(['is_admin' => 1])->create()->id
        ])->create();

        $response = $this->get(route('posts.show', ['post' => $post]));

        $response->assertOk();

        $response->assertSeeText('Comments');

        $response->assertSee('<h2 style="color: red">Comments:</h2>', false);
    }
}
