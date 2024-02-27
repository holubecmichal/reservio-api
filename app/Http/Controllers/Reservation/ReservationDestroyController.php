<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\ReservationDestroyRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationDestroyRequest $request): Response
    {
        $user = $request->user();

        $reservation = $user->reservations()->findOrFail($request->route('id'));

        $reservation->delete();

        return response()->noContent();
    }
}
