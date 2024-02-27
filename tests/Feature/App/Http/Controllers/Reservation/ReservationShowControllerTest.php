<?php

namespace Tests\Feature\App\Http\Controllers\Reservation;

use App\Http\Controllers\Reservation\ReservationShowController;
use Database\Factories\ReservationFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReservationShowControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_show(): void
    {
        $user = UserFactory::new()->createOne();

        $reservation = ReservationFactory::new()->for($user)->createOne();

        Sanctum::actingAs($user);

        $response = $this->getJson(URL::action(ReservationShowController::class, [
            'id' => $reservation->getId(),
        ]));

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => $this->reservationShowStructure()
        ]);
    }

    public function test_reservation_show_not_found(): void
    {
        $user = UserFactory::new()->createOne();

        $reservation = ReservationFactory::new()->for(UserFactory::new())->createOne();

        Sanctum::actingAs($user);

        $response = $this->getJson(URL::action(ReservationShowController::class, [
            'id' => $reservation->getId(),
        ]));

        $response->assertNotFound();
    }

    public function test_reservation_show_unauthenticated(): void
    {
        $reservation = ReservationFactory::new()->for(UserFactory::new())->createOne();

        $response = $this->getJson(URL::action(ReservationShowController::class, [
            'id' => $reservation->getId(),
        ]));

        $response->assertUnauthorized();
    }
}
