<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{

    public function test_show_method()
    {
        $post = Post::factory()->hasComments(5)->create();

        $response = $this->get(route('posts.show', ['post' => $post]));

        $response->assertOk();

        $response->assertSeeText("Comments");

        $response->assertViewHas('post', $post);
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
            "<input type=\"hidden\" name=\"post_id\" value=\"$post->id\">",
            '<input type="submit" value="submit">'
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
        $post = Post::factory()->hasComments(5)->create();

        $response = $this->get(route('posts.show', ['post' => $post]));

        $response->assertOk();

        $response->assertSeeText('Comments');

        $response->assertSee('<h2 style="color: red">Comments:</h2>', false);
    }
}
