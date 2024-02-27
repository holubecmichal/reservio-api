<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\ReservationShowRequest;
use App\Http\Resources\ReservationShowResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationShowRequest $request): Response
    {
        $user = $request->user();

        $reservation = $user->reservations()->findOrFail($request->route('id'));

        return (new ReservationShowResource($reservation))->toResponse($request);
    }
}
