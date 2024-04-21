<?php

namespace App\Services\Api\V1\Common;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Faux\Group;

class GroupService
{
    /**
     * Prepare data for Faux Group resource request from API
     *
     * @param Group $group
     * @param int $perPage
     *
     * @return Collection | LengthAwarePaginator
     */
    public function getGroupData(Group $group, int $perPage): Collection | LengthAwarePaginator
    {
        return $perPage
            ? $group->students()->paginate($perPage)
            : $group->students;
    }
}
