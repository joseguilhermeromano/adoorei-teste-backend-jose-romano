<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * General API Testing
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/api');

        $response->assertStatus(200);

        $response->assertJson([
            'success' => 'Seja bem-vindo à nossa API - ABC'
        ]);
    }

    public function test_the_application_returns_a_successful_root_path(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function test_the_application_return_404_inexistent_path():void
    {
        $response = $this->get('/inexistent');

        $response->assertStatus(404);

        $response->assertJson([
            'error' => 'Resource not found'
        ]);
    }
}
