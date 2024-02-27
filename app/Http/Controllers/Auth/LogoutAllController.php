<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogoutAllRequest;
use Illuminate\Http\Request;

class LogoutAllController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LogoutAllRequest $request)
    {
        $request->user()->tokens()->delete();

        return response()->make();
    }
}
