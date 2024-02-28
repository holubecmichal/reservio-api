<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Requests\Reservation\ReservationUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ReservationUpdateController extends AbstractController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationUpdateRequest $request): Response
    {
        $user = $request->user();

        $reservation = $user->reservations()->findOr(
            $request->route('id'),
            callback: static fn () => throw new ModelNotFoundException(__('Not found'))
        );

        $reservation->update($request->validated());

        $this->forgetReservationCache($user, $reservation);

        return response()->noContent();
    }
}
