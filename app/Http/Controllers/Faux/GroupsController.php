<?php

namespace App\Http\Controllers\Faux;

use App\Services\Faux\GroupsByStudentsService;
use App\Http\Requests\Faux\GroupsRequest;
use App\Http\Controllers\Controller;

class GroupsController extends Controller
{
    /**
     * @var GroupsByStudentsService $service
     */
    protected GroupsByStudentsService $service;

    public function __construct()
    {
        $this->service = new GroupsByStudentsService();
    }

    /** Show groups filtered by amount of its members (students)
     *
     * @param GroupsRequest $request
    */
    public function showFilteredGroups(GroupsRequest $request)
    {
        $groupsData = $this->service->getGroupsData($request);

        return view('faux.groups', compact('groupsData'));
    }
}
