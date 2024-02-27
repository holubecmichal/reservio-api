<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MeRequest;
use App\Http\Resources\MeResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MeRequest $request): Response
    {
        $user = $request->user();

        return response()->json(new MeResource($user));
    }
}
