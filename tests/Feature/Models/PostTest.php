<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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

    public function test_posts_has_many_tags()
    {
        $post = Post::factory()
            ->for(User::factory())
            ->has(Tag::factory()->count(5))
            ->create();

        $this->assertInstanceOf(Post::class, $post);

        $this->assertTrue($post->tags()->pluck('post_id')->contains($post->id));

        $this->assertDatabaseCount('tags', 5);

        $this->assertInstanceOf(Tag::class, $post->tags()->first());
    }
}


/*

Assert that the tags belong to the correct post.

Assert that the tags are instances of the Tag model.

Assert that the pivot table contains the correct data.

Assert that a specific tag is associated with the post.

Assert that the relationship is properly defined in the Post and Tag models.

Assert that the tags can be retrieved through the post's relationship.

Assert that the post can be retrieved through the tag's relationship.

Assert that the pivot table timestamps are populated (if applicable).

Assert that deleting a post also removes its associated tags from the pivot table.

Assert that deleting a tag also removes its associated posts from the pivot table.

Assert that attaching a tag to a post works correctly.

Assert that detaching a tag from a post works correctly.

Assert that syncing tags for a post works correctly.

Assert that the relationship is bidirectional (post->tags and tag->posts).





*/
