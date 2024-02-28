<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Requests\Reservation\ReservationDestroyRequest;
use App\Notifications\ReservationCanceledNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ReservationDestroyController extends AbstractController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationDestroyRequest $request): Response
    {
        $user = $request->user();

        $reservation = $user->reservations()->findOr(
            $request->route('id'),
            callback: static fn () => throw new ModelNotFoundException(__('Not found'))
        );

        $reservation->delete();

        $this->forgetReservationCache($user, $reservation);

        $user->notify(new ReservationCanceledNotification($reservation->getId()));

        return response()->noContent();
    }
}
