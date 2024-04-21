<?php

namespace App\Http\Controllers\Api\V1\Admin\Faux;

use App\Http\Resources\Api\V1\Admin\Faux\StudentsResource;
use App\Http\Controllers\Controller;
use App\Models\Faux\Student;
use Exception;

class StudentsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/students",
     *     operationId="studentsList",
     *     summary="Get Students List",
     *     description="Get data for all students",
     *     tags={"Admin"},
     *     security={{ "bearerAuth": {} }},
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
     *                     @OA\Property(property="id", type="integer", example="1", description="Student ID"),
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
     *                     @OA\Property(property="action", type="string", example="get_students_list", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke()
    {
        try {
            $students = Student::with('group')->with('courses')->orderBy('students.id');
        } catch (Exception $err) {
            return response()->json(
                [
                    'error' => [
                        'action' => 'get_students_list',
                        'message' => $err->getMessage()
                    ]
                ],
                422
            );
        }

        return new StudentsResource($students);
    }
}
