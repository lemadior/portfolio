<?php

namespace App\Http\Controllers\Faux;

use App\Http\Requests\Faux\GroupRequest;
use App\Http\Controllers\Controller;
use App\Models\Faux\Group;

class GroupController extends Controller
{
    /**
     * Show group data with student members
     *
     * @param GroupRequest $request
     * @param Group $group
     */
    public function showGroupData(GroupRequest $request, Group $group)
    {
        $data = $request->validated();

        $studentsPerPage = $data['per_page'] ?? 5;

        $students = $group->students()->paginate($studentsPerPage);

        return view('faux.group', compact('group', 'students', 'studentsPerPage'));
    }
}
