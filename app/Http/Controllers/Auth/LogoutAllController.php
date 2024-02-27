<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogoutAllRequest;
use Symfony\Component\HttpFoundation\Response;

class LogoutAllController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LogoutAllRequest $request): Response
    {
        $request->user()->tokens()->delete();

        return response()->noContent();
    }
}
