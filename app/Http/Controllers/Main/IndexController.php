<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     title="Faux Api",
 *     version="1.0"
 * ),
 * @OA\PathItem(
 *     path="/api/v1/"
 * ),
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer"
 *     )
 * ),
 * @OA\Server(
 *     url="http://localhost:5000/api/v1"
 * )
 */
class IndexController extends Controller
{
    // This is a start point
    public function index()
    {
        return view('main.index');
    }
}
