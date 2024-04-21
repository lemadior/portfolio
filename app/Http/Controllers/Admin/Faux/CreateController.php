<?php

namespace App\Http\Controllers\Admin\Faux;

use App\Http\Controllers\Controller;
use App\Models\Faux\Course;
use App\Models\Faux\Group;

class CreateController extends Controller
{
    public function create()
    {
        $groups = Group::all();

        $courses = Course::all();

        return view('admin.faux.create', compact('groups', 'courses'));
    }
}
