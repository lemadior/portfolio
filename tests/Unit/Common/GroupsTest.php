<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Faux\Group;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class GroupsTest extends TestCase
{
    use RefreshDatabase, DBSetup;

    public function setUp(): void
    {
        parent::setUp();

        $this->setDatabase();
    }

    /**
     * The data set for testing returned predefined name of the groups
     *
     * @return array
     */
    public static function groupsNameProvider(): array
    {
        return [
            [
                [
                    'IL-24', 'YF-22', 'JA-20', 'CO-22', 'NX-21',
                    'XT-24', 'IR-24', 'KR-22', 'KN-20', 'HZ-22'
                ]
            ]
        ];
    }

    /**
     * A test if the Group model has been setup 'groups' table correctly.
     *
     * @dataProvider groupsNameProvider
     *
     */
    public function testGroupDataFromDatabase($testGroups): void
    {
        $groups = Group::all()->pluck('name')->toArray();

        $this->assertEqualsCanonicalizing($testGroups, $groups);
    }
}
