<?php

namespace App\Http\Controllers\Api\V1\Admin\Faux;

use App\Http\Resources\Api\V1\Admin\Faux\CoursesResource;
use App\Http\Controllers\Controller;
use App\Models\Faux\Course;
use Exception;

class CoursesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/courses",
     *     operationId="courses",
     *     summary="Get Courses List",
     *     description="Get data for all courses",
     *     tags={"Admin"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(description="Data array",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example="1", description="Student ID"),
     *                     @OA\Property(property="name", type="string", example="Math", description="Course name"),
     *                     @OA\Property(property="description", type="string", example="Something about numbers", description="Course short description")
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
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *                 @OA\Property(property="error", type="string", example="Token not provided")
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
     *                     @OA\Property(property="action", type="string", example="get_courses_list", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke()
    {
        try {
            $courses = Course::all();
        } catch (Exception $err) {
            return response()->json(
                [
                    'error' => [
                        'action' => 'get_courses_list',
                        'message' => $err->getMessage()
                    ]
                ],
                422
            );
        }

        return new CoursesResource($courses);
    }
}
