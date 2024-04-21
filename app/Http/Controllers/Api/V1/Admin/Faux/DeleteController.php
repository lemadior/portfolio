<?php

namespace App\Http\Controllers\Api\V1\Admin\Faux;

use App\Services\Api\V1\Admin\Faux\DeleteService;
use App\Http\Controllers\Controller;
use App\Models\Faux\Student;
use Exception;

class DeleteController extends Controller
{
    /**
     * @var DeleteService $service
     */
    protected DeleteService $service;

    public function __construct()
    {
        $this->service = new DeleteService();
    }

    /**
     * @OA\Delete(
     *     path="/students/{student}",
     *     operationId="studentDelete",
     *     summary="Student delete",
     *     description="Delete student data",
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
     *                     @OA\Property(property="action", type="string", example="delete_student'", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="error", type="object",
     *                     @OA\Property(property="action", type="string", example="delete_student'", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(Student $student)
    {
        if (!$student) {
            return response()->json(
                $this->prepareError('Student not found'),
                404
            );
        }

        try {
            $deletedId = $this->service->deleteStudent($student);
        } catch (Exception $err) {
            return response()->json(
                $this->prepareError($err->getMessage()),
                422
            );
        }

        return [
            'data' => ['message' => 'Student with ID ' . $deletedId . ' was successfully deleted']
        ];
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
                'action' => 'delete_student',
                'message' => $message
            ]
        ];
    }
}
