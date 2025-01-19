<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_new_post()
    {
        $user = User::factory()->create();

        $post = Post::factory()->for($user)->make()->toArray();
        // bejaie for, mitoni to PostFactory, meghdare "user_id" => User::factory ro benevisi.

        Post::query()->create($post);

        $this->assertDatabaseHas('posts', $post);
    }

    public function test_post_belongs_to_user()
    {
        $user = User::factory()->create();

        $post = Post::factory()->for($user)->create();

        $this->assertDatabaseHas('users', $user->toArray());

        $this->assertTrue(isset($post->user->id));

        $this->assertInstanceOf(Post::class, $user->posts->first());
    }
}
