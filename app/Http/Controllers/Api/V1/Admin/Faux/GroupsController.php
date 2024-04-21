<?php

namespace App\Http\Controllers\Api\V1\Admin\Faux;

use App\Http\Resources\Api\V1\Admin\Faux\GroupsResource;
use App\Http\Controllers\Controller;
use App\Models\Faux\Group;
use Exception;

class GroupsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/groups",
     *     operationId="groups",
     *     summary="Get Groups List",
     *     description="Get data for all groups",
     *     tags={"Admin"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(description="Data array",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example="1", description="Student ID"),
     *                     @OA\Property(property="name", type="string", example="AA-00", description="Group name"),
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
     *                     @OA\Property(property="action", type="string", example="get_groups_list", description="name of the action where error is occurred"),
     *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke()
    {
        try {
            $groups = Group::all();
        } catch (Exception $err) {
            return response()->json(
                [
                    'error' => [
                        'action' => 'get_groups_list',
                        'message' => $err->getMessage()
                    ]
                ],
                422
            );
        }

        return new GroupsResource($groups);
    }
}
