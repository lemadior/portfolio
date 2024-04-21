<?php

namespace App\Http\Controllers\Admin\Faux;

use App\Http\Controllers\Controller;
use App\Models\Faux\Student;

class DeleteController extends Controller
{
    public function delete(Student $student)
    {
        $student->delete();

        return redirect()->route('admin.faux.index');
    }
}
