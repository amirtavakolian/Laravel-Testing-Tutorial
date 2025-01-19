<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
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

        $response = $this->get(route('home'));

        $response->assertOk();

        $response->assertSeeText('Welcome');

        $response->assertCookie('laravel_session');

        $response->assertViewIs('home');
    }
}
