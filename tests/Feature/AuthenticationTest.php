<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use refreshDatabase;
    use DatabaseMigrations;
    public function testBasic()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
