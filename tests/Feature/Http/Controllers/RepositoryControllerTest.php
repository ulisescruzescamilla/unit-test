<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_auth_redirect()
    {
        $this->get('repositories')->assertRedirect('login');
        $this->post('repositories',[])->assertRedirect('login');
        $this->get('repositories/create')->assertRedirect('login');
        $this->get('repositories/1')->assertRedirect('login');
        $this->put('repositories/1')->assertRedirect('login');
        $this->delete('repositories/1')->assertRedirect('login');
        $this->get('repositories/1/edit')->assertRedirect('login');
    }

    public function test_store()
    {
        // create payload
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->word
        ];
        // create user from faker
        $user = User::factory()->create();
     
        // send payload to create
        // asserts:
        // acting as user
        // post to repositories
        // redirectTo index repositories
        $this
            ->actingAs($user)
            ->post('repositories', $data)
            ->assertRedirect('repositories');

        // check data created on DB
        // assertDatabaseHas
        $this->assertDatabaseHas('repositories', $data);
    }
}
