<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupByIdTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * The data set with available group IDs
     *
     * @return array
     */
    public static function groupsIdProvider(): array
    {
        return [
            [1], [2], [3], [4], [5], [6], [7], [8], [9], [10]
        ];
    }

    /**
     * A basic test to load group page with specified id
     *
     * @dataProvider groupsIdProvider
     *
     * @return void
     */
    public function testShowGroupById($id): void
    {
        $response = $this->get("/faux/groups/${id}");

        $response->assertStatus(200);
        $response->assertViewIs('faux.group');
    }
}
