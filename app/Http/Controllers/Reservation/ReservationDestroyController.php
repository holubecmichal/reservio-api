<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\ReservationDestroyRequest;
use App\Notifications\ReservationCanceledNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ReservationDestroyController extends AbstractController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationDestroyRequest $request): Response
    {
        $user = $request->user();

        $reservation = $user->reservations()->findOrFail($request->route('id'));

        $reservation->delete();

        $this->forgetReservationCache($user, $reservation);

        $user->notify(new ReservationCanceledNotification($reservation->getId()));

        return response()->noContent();
    }
}
