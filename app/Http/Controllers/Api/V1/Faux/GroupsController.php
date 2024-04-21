<?php

namespace App\Http\Controllers\Api\V1\Faux;

use App\Http\Requests\Api\V1\Faux\GroupsFilterRequest;
use App\Http\Resources\Api\V1\Faux\GroupsResource;
use App\Services\Api\V1\Faux\GroupsFilterService;
use App\Http\Controllers\Controller;
use Exception;

class GroupsController extends Controller
{
    /**
     * @var GroupsFilterService $service
     */
    protected GroupsFilterService $service;

    public function __construct()
    {
        $this->service = new GroupsFilterService();
    }

    /**
     * @OA\Get(
     *     path="/filter/groups?members=15",
     *     operationId="groupsByStudents",
     *     summary="Filter groups by students",
     *     description="Get groups filtered by its members",
     *     tags={"FAUX"},
     *     @OA\Parameter(
     *         description="Group members",
     *         in="query",
     *         name="members",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="15", value="15", summary="Groups with specified members"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(description="Data array",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer", example="2", description="Group ID"),
     *                             @OA\Property(property="name", type="string", example="AA-00", description="Group name"),
     *                             @OA\Property(property="students", type="integer", example="15", description="Students amount")
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
     *                     @OA\Property(property="action", type="string", example="filter_groups", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(GroupsFilterRequest $request)
    {
        $data = $request->validated();

        try {
            $result = $this->service->getGroupsDependsOnMembersAmount($data['members']);
        } catch (Exception $err) {
            return response()->json(
                [
                    'error' => [
                        'action' => 'fliter_groups',
                        'message' => $err->getMessage()
                    ]
                ],
                422
            );
        }

        return new GroupsResource($result);
    }
}
