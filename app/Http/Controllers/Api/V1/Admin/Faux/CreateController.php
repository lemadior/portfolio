<?php

namespace App\Http\Controllers\Api\V1\Admin\Faux;

use App\Http\Resources\Api\V1\Admin\Faux\CreateResource;
use App\Http\Requests\Api\V1\Admin\Faux\StudentDataRequest;
use App\Services\Api\V1\Admin\Faux\CreateService;
use App\Http\Controllers\Controller;
use Exception;

class CreateController extends Controller
{
    /**
     * @var CreateService $service
     */
    protected CreateService $service;

    public function __construct()
    {
        $this->service = new CreateService();
    }

    /**
     * @OA\Post(
     *     path="/students",
     *     operationId="studentCreate",
     *     summary="Student Create",
     *     description="Create the new student",
     *     tags={"Admin"},
     *     security={{ "bearerAuth": {} }},
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="student_id", type="integer", example=42, description="ID of the newly created student record"),
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
     *                     @OA\Property(property="action", type="string", example="create_student", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(StudentDataRequest $request)
    {
        $data = $request->validated();

        try {
            $result = $this->service->createNewStudent($data);
        } catch (Exception $err) {
            return response()->json(
                [
                    'error' => [
                        'action' => 'create_student',
                        'message' => $err->getMessage()
                    ]
                ],
                422
            );
        }

        return new CreateResource($result);
    }
}
