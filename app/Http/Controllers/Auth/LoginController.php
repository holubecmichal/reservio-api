<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\ApiTokenResource;
use App\Http\Resources\MeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): Response
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            $this->sendFailedLoginResponse();
        }

        $user = Auth::user();

        if ($user === null) {
            $this->sendFailedLoginResponse();
        }

        $token = $user->createToken('reservio-api');

        return response()->json(new ApiTokenResource($token), Response::HTTP_OK);
    }

    protected function sendFailedLoginResponse(): never
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
            'password' => [trans('auth.failed')],
        ])->status(Response::HTTP_UNAUTHORIZED);
    }
}
