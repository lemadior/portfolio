<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\Faux\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Post(
 *     path="/auth/login",
 *     operationId="authUser",
 *     summary="Get token to works with API for admin tasks",
 *     description="Get token for existent user",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="email", type="string", example="user@example.com"),
 *                     @OA\Property(property="password", type="string", example="12345"),
 *                )
 *             }
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Current token",
 *             @OA\Property(property="token", type="string", example="<token>", description="Admin Authentication Token"),
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
 *     )
 * )
 */
class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect(route('admin.faux.index'));
        }

        return view('auth.login');
    }

    /**
     * Method to proceed POST request from login page
     *
     * @param LoginRequest $request
     */
    public function loginPost(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            return redirect()->intended(route('admin.faux.index'));
        }

        Log::error('[LOGIN] wrong login attempt for user with email: ' . $data['email']);

        return redirect(route('auth.login'))->with('error', 'Login details are not valid')->withInput();
    }
}
