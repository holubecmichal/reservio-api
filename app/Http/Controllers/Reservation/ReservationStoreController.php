<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\ReservationStoreRequest;
use App\Http\Resources\ReservationShowResource;
use App\Models\Reservation;
use Symfony\Component\HttpFoundation\Response;

class ReservationStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationStoreRequest $request): Response
    {
        $user = $request->user();

        $data = $request->validated();

        $reservation = $user->reservations()->create($data);

        return (new ReservationShowResource($reservation))->toResponse($request);
    }
}
