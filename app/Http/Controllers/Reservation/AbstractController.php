<?php

namespace App\Http\Controllers\Reservation;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AbstractController
{
    protected function getReservationCacheKey(User $user, int $reservationId): string
    {
        return "reservation_show_{$user->getId()}_{$reservationId}";
    }

    protected function forgetReservationCache(User $user, Reservation $reservation): void
    {
        Cache::forget($this->getReservationCacheKey($user, $reservation->getId()));
    }
}
