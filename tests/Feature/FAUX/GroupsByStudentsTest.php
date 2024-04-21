<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupsByStudentsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * A basic test to check if find groups by student amount works correctly
     *
     * @return void
     */
    public function testReturnsGroupByStudentsAmount(): void
    {
        $response = $this->post('/faux/filter/groups', ['amount' => 50]); // 50 to get all possible groups

        $content = $response->getContent();
        $rowCount = substr_count($content, '<tr>');

        $response->assertStatus(200);
        $response->assertViewIs('faux.groups');

        // If more than 1 row present on the page it means that all works correctly
        $this->assertGreaterThan(1, $rowCount);
    }
}
