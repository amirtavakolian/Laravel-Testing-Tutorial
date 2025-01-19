<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_insert_data()
    {
        // in test/method, vazifeie test kardan E insert shodane data to database az tarighe model ro dare.

        // age in test faile beshe, az esme method rahat mifahmim,
        // mortabet be kodom bakhash az site bode ke failed shode
        // ta betonim rahat moshkel ro hal konim.

        // esme method hatman baiad ba test shoro beshe
        // ya inke balaie signature E method @test ro bezari to doc block

        //==========================================

        // ye seri data insert mikonim to db
        // check mikonim aya data insert shode ya na

        $user = User::factory()->unverified()->create();

        $this->assertDatabaseHas('users', $user->toArray());

        $this->assertDatabaseCount('users', 1);

    }

    public function test_insert_data_in_users_table()
    {
        $user = User::factory()
            ->state(new Sequence(['email' => 'aa@aa.com'], ['email' => 'a2a@aa.com']))
            ->make()->toArray();

        $user['password'] = Hash::make('123456');

        User::query()->create($user);

        $this->assertDatabaseHas('users', $user);

        // in test ro ke neveshti, ye column be migration E users ezafe kon
        // dobare test ro run kon ==> failed mishe in test

        // ine khobie test nevisi :D :P

    }

    public function test_user_has_many_posts()
    {
        $user = User::factory()->hasPosts(3)->create();

        $this->assertInstanceOf(Collection::class, $user->posts);

        $this->assertTrue($user->id == $user->posts->first()->user_id);

        $this->assertInstanceOf(Post::class, $user->posts()->first());

        $this->assertDatabaseCount('posts', 3);
    }

    public function test_user_has_many_posts1()
    {
        $user = User::factory()->create();

        $posts = Post::factory()->for($user)->count(5)->create();

        $this->assertInstanceOf(Collection::class, $user->posts);

        $this->assertTrue($user->posts->contains($posts->first()));

    }

    public function test_user_has_many_posts_2()
    {
        $user = User::factory()->create();

        $posts = Post::factory()->count(5)->for($user)->make()->toArray();

        $user->posts()->insert($posts);

        $this->assertInstanceOf(Collection::class, $user->posts);
    }
}
