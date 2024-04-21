<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Http\Resources\Api\V1\Common\CourseResource;
use App\Http\Requests\Api\V1\Common\LimitRequest;
use App\Services\Api\V1\Common\CourseService;
use App\Http\Controllers\Controller;
use App\Models\Faux\Course;
use Exception;

class CourseController extends Controller
{
    /**
     * @var CourseService $service
     */
    protected CourseService $service;

    public function __construct()
    {
        $this->service = new CourseService();
    }

    /**
     * @OA\Get(
     *     path="/courses/{course}",
     *     operationId="studentsInCourse",
     *     summary="Course students",
     *     description="Get students belongs to the course",
     *     tags={"Common data"},
     *     @OA\Parameter(
     *         description="Course ID",
     *         in="path",
     *         name="course",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="1", value="1", summary="Data of course with ID=1"),
     *     ),
     *     @OA\Parameter(
     *         description="Elements per page",
     *         in="query",
     *         name="limit",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="5", value="5", summary="Five elements per page"),
     *     ),
     *     @OA\Parameter(
     *         description="Page number",
     *         in="query",
     *         name="page",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="", value="", summary="Page number"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(description="Data array",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="name", type="string", example="Astrology", description="Course name"),
     *                     @OA\Property(property="students", type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer", example="1", description="Student ID"),
     *                             @OA\Property(property="name", type="string", example="Domenica Kris", description="Student name"),
     *                             @OA\Property(property="group", type="string", example="AA-00", description="Group name")
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
     *                 @OA\Property(property="error", type="string", example="Wrong request!")
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
     *                     @OA\Property(property="action", type="string", example="get_course", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(LimitRequest $request, Course $course)
    {
        $data = $request->validated();

        $limit = $data['limit'] ?? 0;

        try {
            $students = $this->service->getCourseData($course, $limit);
        } catch (Exception $err) {
            return response()->json(
                [
                    'error' => [
                        'action' => 'get_course',
                        'message' => $err->getMessage()
                    ]
                ],
                422
            );
        }

        return new CourseResource([
            'course' => $course,
            'students' => $students
        ]);
    }
}
