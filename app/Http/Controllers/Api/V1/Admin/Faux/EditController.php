<?php

namespace App\Http\Controllers\Api\V1\Admin\Faux;

use App\Http\Requests\Api\V1\Admin\Faux\StudentDataRequest;
use App\Http\Resources\Api\V1\Admin\Faux\EditResource;
use App\Services\Api\V1\Admin\Faux\EditService;
use App\Http\Controllers\Controller;
use App\Models\Faux\Student;
use Exception;

class EditController extends Controller
{
    /**
     * @var EditService $service
     */
    protected EditService $service;

    public function __construct()
    {
        $this->service = new EditService();
    }

    /**
     * @OA\Patch(
     *     path="/students/{student}",
     *     operationId="studentEdit",
     *     summary="Student edit",
     *     description="Edit student data",
     *     tags={"Admin"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         description="Student ID",
     *         in="path",
     *         name="student",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="5", value="5", summary="Student ID"),
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="group_id", type="integer", example=2),
     *                     @OA\Property(property="first_name", type="string", example="Domenica"),
     *                     @OA\Property(property="last_name", type="string", example="Denesik"),
     *                     @OA\Property(property="course_ids", type="array",
     *                         @OA\Items(type="integer", description="Course ID", @OA\Schema(type="number"))
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(description="Data array",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="message", type="string", example="Success", description="Result of the edit of the student data"),
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
     *         description="Resource not found",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="error", type="object",
     *                     @OA\Property(property="action", type="string", example="edit_student'", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="error", type="object",
     *                     @OA\Property(property="action", type="string", example="edit_student'", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(StudentDataRequest $request, Student $student)
    {
        if (!$student) {
            return response()->json(
                $this->prepareError('Student not found'),
                404
            );
        }

        $data = $request->validated();

        $data['student'] = $student;
        $data['current_course_ids'] = $student->courses->pluck('id')->toArray();

        // Prevent to change the group ID except it has NULL value
        $data['group_id'] = $student->group ? $student->group->id : $data['group_id'];

        try {
            $result = $this->service->editStudent($data);
        } catch (Exception $err) {
            return response()->json(
                $this->prepareError($err->getMessage()),
                422
            );
        }

        return new EditResource($result);
    }


    /**
     * Prepare response array in case when error is occurred
     *
     * @param string $message
     *
     * @return array
     */
    protected function prepareError(string $message): array
    {
        return [
            'error' => [
                'action' => 'edit_student',
                'message' => $message
            ]
        ];
    }
}
