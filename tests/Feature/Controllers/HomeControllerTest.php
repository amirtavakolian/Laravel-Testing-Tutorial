<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method()
    {
        /*
          in test check mikone vaghti karbar be safheie index E ma request mizane
          aya un safhe be dorosti barmigarde be karbar ya na?

          az unjaii ke vaghti be safheie asli E site ma request miad,
          un request be HomeController mire, pas, esme class E test E ma mishe
          HomeControllerTest

          method E index E HomeController, ye viewii be karbar baiad returen kone
          va esme un method index hastesh
          ==>
          pas, esme method E testemon ro gozasthim test_index_method
        */

        Post::factory()->count(5)->create();

        $response = $this->get(route('home'));

        $response->assertOk();

        $response->assertSeeText('Welcome');

        $response->assertCookie('laravel_session');

        $response->assertViewIs('home');

        $response->assertViewHas('posts', Post::all());


        // vaghti in test pass mishe, yani karbari ke request mizane,
        // bedone moshkel mitone safhe index ro bebine :D

        // age taghiri to controller eijad konim (Ex: view taghir kone, variable E posts taghir kone ya...)
        // va age in assert ha fail beshan, pas kheili rahat mifahmim ke kojaie karemon moshkel pish omade.

    }
}
