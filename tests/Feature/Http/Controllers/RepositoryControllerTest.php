<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
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

    public function test_index_empty()
    {
        // when index is empty
        Repository::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee('No repositories created');
    }

    public function test_index_with_data()
    {
        // when index is empty
        $user = User::factory()->create();
        $repository = Repository::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee($repository->id)
            ->assertSee($repository->url);
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

    public function test_update()
    {
        // create payload
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->word
        ];
        // create user from faker
        $user = User::factory()->create();

        $repository = Repository::factory()->create([
            'user_id' => $user->id
        ]);

        // send payload to create
        // asserts:
        // acting as user
        // post to repositories
        // redirectTo index repositories
        $this
            ->actingAs($user)
            ->put("repositories/{$repository->id}", $data)
            ->assertRedirect("repositories/{$repository->id}/edit");

        // check data created on DB
        // assertDatabaseHas
        $this->assertDatabaseHas('repositories', $data);
    }

    public function test_validate_store()
    {
        //$this->withoutExceptionHandling();
        // create user from faker
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post('repositories', [])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'url',
                'description'
            ]);

        // check data created on DB
        // assertDatabaseHas
        // $this->assertDatabaseHas('repositories');
    }

    public function test_validate_update()
    {
        // create user from faker
        $user = User::factory()->create();

        $repository = Repository::factory()->create([
            'user_id' => $user->id
        ]);

        // send payload to create
        // asserts:
        // acting as user
        // post to repositories
        // redirectTo index repositories
        $this
            ->actingAs($user)
            ->put("repositories/{$repository->id}", [])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'url',
                'description'
            ]);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create([
            'user_id' => $user->id
        ]);

        $this
            ->actingAs($user)
            ->delete("repositories/{$repository->id}")
            ->assertRedirect('repositories');

        $this->assertDatabaseMissing('repositories', [
            'id' => $repository->id,
            'url' => $repository->url,
            'description' => $repository->description
        ]);
    }

    public function test_update_policy()
    {
        // create user from faker
        $user = User::factory()->create(); // id = 1
        $repository = Repository::factory()->create();// user_id = 2
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text
        ];

        $this
            ->actingAs($user)
            ->put("repositories/{$repository->id}", $data)
            ->assertStatus(403); // policy code error
    }

    public function test_destroy_policy()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create();

        $this
            ->actingAs($user)
            ->delete("repositories/{$repository->id}")
            ->assertStatus(403);
    }
}
