<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Http\Resources\Api\V1\Common\StudentResource;
use App\Services\Api\V1\Common\StudentService;
use App\Http\Controllers\Controller;
use App\Models\Faux\Student;
use Exception;

class ShowController extends Controller
{
    /**
     * @var CourseService $service
     */
    protected StudentService $service;

    public function __construct()
    {
        $this->service = new StudentService();
    }

    /**
     * @OA\Get(
     *     path="/students/{student}",
     *     operationId="studentItself",
     *     summary="Student",
     *     description="Get student's data",
     *     tags={"Common data"},
     *     @OA\Parameter(
     *         description="Student ID",
     *         in="path",
     *         name="student",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="1", value="1", summary="Data of the student with ID=1"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(description="Data array",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="name", type="string", example="Domenica Kris", description="Student's name"),
     *                     @OA\Property(property="group", type="string", example="AA-00", description="Student's group"),
     *                     @OA\Property(property="courses", type="array",
     *                         @OA\Items(
     *                             @OA\Property(type="string", example="Math", description="Course name")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\JsonContent(
     *                 @OA\Property(property="error", type="object", example="Wrong request!")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Resource not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="error", type="object",
     *                     @OA\Property(property="action", type="string", example="get_student", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(Student $student)
    {
        $resourceData = [];

        $resourceData['student'] = $student;

        try {
            $resourceData['courseNames'] = $this->service->getStudentCoursesData($student);
        } catch (Exception $err) {
            return response()->json(
                [
                    'error' => [
                        'action' => 'get_student',
                        'message' => $err->getMessage()
                    ]
                ],
                422
            );
        }

        return new StudentResource($resourceData);
    }
}
