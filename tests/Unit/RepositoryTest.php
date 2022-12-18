<?php

namespace Tests\Unit;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_belongs_to_user()
    {
        $repo = Repository::factory()->create();

        $this->assertInstanceOf(
            User::class, $repo->user
        );
    }
}
