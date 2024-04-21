<?php

namespace App\Services\Resources\Api\V1\Admin\Faux;

class GroupsService
{
    /**
     * Prepare data for Admin Faux Groups resource request from API
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
                'name' => $group->name
            ];
        }

        return [
            'groups' => $groupsData
        ];
    }
}
