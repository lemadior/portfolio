<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Faux\Group;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class GroupsByStudentsAmountTest extends TestCase
{
    use RefreshDatabase, DBSetup;

    public function setUp(): void
    {
        parent::setUp();

        $this->setDatabase();
    }

    /**
     * The data set for testing returned founded groups names depends on the amount of the students
     *
     * @return array
     */
    public static function groupsFilterDataProvider(): array
    {
        return [
            [12, ['IL-24']],
            [14, ['IL-24', 'YF-22']],
            [16, ['IL-24', 'YF-22', 'JA-20']],
            [18, ['IL-24', 'YF-22', 'JA-20', 'CO-22']],
            [20, ['IL-24', 'YF-22', 'JA-20', 'CO-22', 'NX-21']],
            [22, ['IL-24', 'YF-22', 'JA-20', 'CO-22', 'NX-21', 'XT-24']],
            [24, ['IL-24', 'YF-22', 'JA-20', 'CO-22', 'NX-21', 'XT-24', 'IR-24']],
            [26, ['IL-24', 'YF-22', 'JA-20', 'CO-22', 'NX-21', 'XT-24', 'IR-24', 'KR-22']],
            [28, ['IL-24', 'YF-22', 'JA-20', 'CO-22', 'NX-21', 'XT-24', 'IR-24', 'KR-22', 'KN-20']],
            [30, ['IL-24', 'YF-22', 'JA-20', 'CO-22', 'NX-21', 'XT-24', 'IR-24', 'KR-22', 'KN-20', 'HZ-22']]
        ];
    }

    /**
     * A test if the Group model has properly found groups depends on the amount of the students.
     *
     * @dataProvider groupsFilterDataProvider
     *
     */
    public function testGroupByStudentAmount($studentsAmount, $filteredGroups): void
    {
        $groups = Group::with('students')
            ->select('groups.id', 'groups.name')
            ->join('students', 'students.group_id', '=', 'groups.id')
            ->groupBy('students.group_id', 'groups.id')
            ->havingRaw("COUNT(students.id) < $studentsAmount")
            ->orderByRaw('count(students.id)')
            ->get();

        $arr = [];

        foreach ($groups as $group) {
            $arr[] = $group->name;
        }

        $this->assertEqualsCanonicalizing($filteredGroups, $arr);
    }
}
