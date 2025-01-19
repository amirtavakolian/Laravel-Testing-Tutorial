<?php

namespace Tests\Feature\Views;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class LayoutViewTest extends TestCase
{

    public function test_layout_view_render_when_user_is_admin()
    {
        $posts = Post::factory()->count(5)->create();

        $user = User::factory()->state(['is_admin' => 1])->create();

        $this->actingAs($user);

        $view = $this->view('home', compact('posts'));

        $view->assertSeeText('Admin');

        $view->assertSee('<a href="#">Admin Panel</a>', false);

        $view->assertSeeInOrder([
            '<a href="#">',
            'Admin Panel',
            '</a>'
        ], false);
    }

    public function test_layout_view_render_when_user_is_not_admin()
    {
        $user = User::factory()->state(['is_admin' => 0])->create();

        $this->actingAs($user);

        $posts = Post::factory()->count(5)->create();

        $view = $this->view('home', compact('posts'));

        $view->assertDontSeeText('Admin');

        $view->assertDontSee('<a href="#">Admin Panel</a>', false);

    }
}
