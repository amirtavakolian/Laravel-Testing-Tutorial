<?php

namespace Tests\Feature\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_user_can_write_comment_for_posts()
    {
        $user = User::factory()->state(['is_admin' => 0])->create();

        $post = Post::factory()->create();

        $comment = Comment::factory()->state(['user_id' => $user->id])->make()->toArray();

        $this->actingAs($user);

        $response = $this->post(route('comment.store', ['post' => $post]), $comment);

        $response->assertStatus(302);

        $response->assertSessionHas('comment_saved', 'comment added successfully');
    }

    public function test_not_auth_user_cant_write_comment_for_posts()
    {
        $user = User::factory()->state(['is_admin' => 0])->create();

        $post = Post::factory()->create();

        $comment = Comment::factory()->state(['user_id' => $user->id])->make()->toArray();

        $response = $this->post(route('comment.store', ['post' => $post]), $comment);

        $response->assertStatus(302);

        $response->assertRedirect(route('auth.login'));
    }

}
