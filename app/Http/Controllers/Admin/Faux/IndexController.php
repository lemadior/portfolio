<?php

namespace App\Http\Controllers\Admin\Faux;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faux\IndexRequest;
use App\Models\Faux\Student;

class IndexController extends Controller
{
    public function index(IndexRequest $request)
    {
        $data = $request->validated();

        $studentsPerPage = $data['per_page'] ?? 10;

        $students = Student::with('group')->with('courses')->orderBy('id')->paginate($studentsPerPage);

        return view('admin.faux.index', compact('students', 'studentsPerPage'));
    }
}
