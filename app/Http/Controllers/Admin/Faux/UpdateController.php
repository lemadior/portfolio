<?php

namespace App\Http\Controllers\Admin\Faux;

use App\Http\Requests\Admin\Faux\UpdateRequest;
use App\Services\Admin\Faux\UpdateService;
use App\Http\Controllers\Controller;
use App\Models\Faux\Student;

class UpdateController extends Controller
{
    protected UpdateService $service;

    public function __construct()
    {
        $this->service = new UpdateService();
    }

    public function update(UpdateRequest $request, Student $student)
    {
        $this->service->editStudent($request, $student);

        return view('faux.show', compact('student'));
    }
}
