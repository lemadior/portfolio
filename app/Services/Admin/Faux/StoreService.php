<?php

namespace App\Services\Admin\Faux;

use App\Http\Requests\Admin\Faux\StoreRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Faux\Student;
use Exception;

class StoreService
{
    /**
     * Proceed request data and create new student record in the 'students' table
     *
     * @param StoreRequest $request
     *
     * @return array
     */
    public function createStudent(StoreRequest $request): void
    {
        $data = $request->validated();

        $courseIds = $data['course_ids'];
        unset($data['course_ids']);

        try {
            $student = Student::firstOrCreate($data);

            $student->courses()->attach($courseIds);
        } catch (Exception $err) {
            Log::error('[ADMIN:CREATE] cannot create new student: ' . $err->getMessage());
        }
    }
}
