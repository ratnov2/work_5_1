<?php

namespace App\Containers\Pages\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_pages()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
