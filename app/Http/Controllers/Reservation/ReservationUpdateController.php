<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\ReservationUpdateRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationUpdateRequest $request): Response
    {
        $user = $request->user();

        $reservation = $user->reservations()->findOrFail($request->route('id'));

        $reservation->update($request->validated());

        return response()->noContent();
    }
}