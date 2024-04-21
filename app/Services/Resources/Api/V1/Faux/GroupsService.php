<?php

namespace App\Services\Resources\Api\V1\Faux;

class GroupsService
{
    /**
     * Prepare data for Faux Groups resource request from API
     *
     * @param mixed $resource
     *
     * @return array
     */
    public function getGroupsData(mixed $resource): array
    {
        $groups = $resource ?? [];

        $groupsData = [];

        foreach ($groups as $group) {
            $groupsData[] = [
                'id' => $group->id,
                'name' => $group->name,
                'students_amount' => $group->students()->count()
            ];
        }

        return $groupsData;
    }
}
