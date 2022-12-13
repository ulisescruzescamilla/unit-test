<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        $this->withoutExceptionHandling();
        $response = $this->json('POST', '/api/posts', [
            'title' => 'Un mundo feliz',
            'content' => 'Bienvenido al mundo feliz'
        ]);

        $response->assertJsonStructure([
            'id',
            'title',
            'content',
            'created_at',
            'updated_at'
        ])
        ->assertJson([
            'title' => 'Un mundo feliz',
            'content' => 'Bienvenido al mundo feliz'
        ])
        ->assertStatus(201); // new resource created

        $this->assertDatabaseHas('posts', [
            'title' => 'Un mundo feliz',
            'content' => 'Bienvenido al mundo feliz'
        ]);
    }
}
