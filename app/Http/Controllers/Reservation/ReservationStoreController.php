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

        $reservation = Reservation::create([
            'user_id' => $user->getId(),
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
            'description' => $data['description'],
        ]);

        return response()->json(new ReservationShowResource($reservation), Response::HTTP_CREATED);
    }
}
