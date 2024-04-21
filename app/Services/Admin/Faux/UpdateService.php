<?php

namespace App\Services\Admin\Faux;

use App\Http\Requests\Admin\Faux\UpdateRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Faux\Student;
use Exception;

class UpdateService
{
    /**
     * Proceed request data and update data for specified student
     *
     * @param UpdateRequest $request
     * @param Student $student
     *
     * @return array
     */
    public function editStudent(UpdateRequest $request, Student $student): void
    {
        $data = $request->validated();

        // This need to successful update the student's data
        $data['student_id'] = $student->id;

        $courseIds = $data['course_ids'];
        unset($data['course_ids']);

        try {
            $student->update($data);

            $student->courses()->sync($courseIds);

            $student->refresh();
        } catch (Exception $err) {
            Log::error("[ADMIN:UPDATE] cannot update student's data: " . $err->getMessage());
        }
    }
}
