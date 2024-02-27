<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogoutCurrentRequest;
use Symfony\Component\HttpFoundation\Response;

class LogoutCurrentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LogoutCurrentRequest $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
