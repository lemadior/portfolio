<?php

namespace App\Http\Controllers\Api\V1\Faux;

use App\Http\Requests\Api\V1\Faux\StudentsFilterRequest;
use App\Http\Resources\Api\V1\Faux\StudentsResource;
use App\Services\Api\V1\Faux\StudentsFilterService;
use App\Http\Controllers\Controller;
use App\Models\Faux\Course;
use Exception;

class StudentsController extends Controller
{
    /**
     * @var StudentsFilterService $service
     */
    protected StudentsFilterService $service;

    public function __construct()
    {
        $this->service = new StudentsFilterService();
    }

    /**
     * @OA\Get(
     *     path="/filter/students?course_id=1",
     *     operationId="studentsByCourse",
     *     summary="Filter students by course",
     *     description="Get groups filtered by students amount",
     *     tags={"FAUX"},
     *     @OA\Parameter(
     *         description="Course ID",
     *         in="query",
     *         name="course_id",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="2", value="2", summary="Course ID"),
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
     *                     @OA\Property(property="students", type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer", example="3", description="Student ID"),
     *                             @OA\Property(property="name", type="string", example="Domenica Denesik", description="Student name "),
     *                             @OA\Property(property="group", type="string", example="AA-00", description="Group name"),
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Resource not found",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="error", type="object",
     *                     @OA\Property(property="action", type="string", example="filter_students", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content",
     *         @OA\JsonContent(type="object",
     *             @OA\Property(property="error", type="object",
     *                     @OA\Property(property="action", type="string", example="filter_students", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(StudentsFilterRequest $request)
    {
        $data = $request->validated();

        // Data array to pass to the resource
        $resourceData = [];

        $resourceData['limit'] = $data['limit'] ?? 0;

        $resourceData['course'] = Course::find($data['course_id']);

        if (!$resourceData['course']) {
            return response()->json(
                $this->prepareError('Course with ID=' . $data['course_id'] . ' doesn\'t found'),
                404
            );
        }

        try {
            $resourceData['students'] = $this->service->getStudentsData(
                $resourceData['course'],
                $resourceData['limit']
            );
        } catch (Exception $err) {
            return response()->json(
                $this->prepareError($err->getMessage()),
                422
            );
        }

        return new StudentsResource($resourceData);
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
                'action' => 'filter_students',
                'message' => $message
            ]
        ];
    }
}
