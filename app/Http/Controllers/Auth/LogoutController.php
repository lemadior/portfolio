<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect(route('main.index'))->setStatusCode(302);
    }
}
