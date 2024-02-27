<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Requests\Reservation\ReservationStoreRequest;
use App\Http\Resources\ReservationShowResource;
use App\Notifications\ReservationCreatedNotification;
use Symfony\Component\HttpFoundation\Response;

class ReservationStoreController extends AbstractController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationStoreRequest $request): Response
    {
        $user = $request->user();

        $data = $request->validated();

        $reservation = $user->reservations()->create($data);

        $user->notify(new ReservationCreatedNotification($reservation));

        return (new ReservationShowResource($reservation))->toResponse($request);
    }
}
