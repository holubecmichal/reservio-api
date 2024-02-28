<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Requests\Reservation\ReservationShowRequest;
use App\Http\Resources\ReservationShowResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ReservationShowController extends AbstractController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationShowRequest $request): Response
    {
        $user = $request->user();

        $reservation = $this->getReservation($user, $request);

        return (new ReservationShowResource($reservation))->toResponse($request);
    }

    public function getReservation(User $user, ReservationShowRequest $request): mixed
    {
        $cacheKey = $this->getReservationCacheKey($user, $request->route('id'));

        $callback = static fn () => $user->reservations()->findOr(
            $request->route('id'),
            callback: static fn () => throw new ModelNotFoundException(__('Not found'))
        );

        return Cache::remember($cacheKey, now()->addMinutes(10), $callback);
    }
}
