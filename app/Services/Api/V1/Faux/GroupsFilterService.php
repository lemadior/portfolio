<?php

namespace App\Services\Api\V1\Faux;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Faux\Group;

class GroupsFilterService
{
    /**
     * Proceed data for Faux Groups Filter request from API
     *
     * @param int $amount // Amount of members for groups filter
     *
     * @return Collection
     */
    public function getGroupsDependsOnMembersAmount(int $amount): Collection
    {
        return Group::with('students')
            ->select('groups.id', 'groups.name')
            ->join('students', 'students.group_id', '=', 'groups.id')
            ->groupBy('students.group_id', 'groups.id')
            ->havingRaw("COUNT(students.id) < ${amount}")
            ->orderByRaw('count(students.id)')
            ->get();
    }
}
