<?php

namespace App\Services\Faux;

use App\Http\Requests\Faux\GroupsRequest;
use Illuminate\Http\Request;
use App\Models\Faux\Group;

class GroupsByStudentsService
{
    /**
     * Prepare data for Faux Groups depends on specified students amount
     *
     * @param Request $request
     * @param mixed $resource
     *
     * @return array
     */
    public function getGroupsData(GroupsRequest $request): array
    {
        $groupsData = [];

        $data = $request->validated();

        $groupsData['amount'] = $data['amount'] ?? 0;

        $groupsData['groups'] = Group::with('students')
            ->select('groups.id', 'groups.name')
            ->join('students', 'students.group_id', '=', 'groups.id')
            ->groupBy('students.group_id', 'groups.id')
            ->havingRaw("COUNT(students.id) < " . $groupsData['amount'])
            ->orderByRaw('count(students.id)')
            ->get();

        return $groupsData;
    }
}
