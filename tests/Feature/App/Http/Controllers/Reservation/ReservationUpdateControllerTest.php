<?php

namespace Tests\Feature\App\Http\Controllers\Reservation;

use App\Http\Controllers\Reservation\ReservationShowController;
use Database\Factories\ReservationFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReservationUpdateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_update(): void
    {
        $user = UserFactory::new()->createOne();

        $reservation = ReservationFactory::new()->for($user)->createOne();

        Sanctum::actingAs($user);

        $response = $this->putJson(URL::action(ReservationShowController::class, ['id' => $reservation->getId()]), [
            'start_at' => Carbon::now()->addDay()->toDateTimeString(),
            'end_at' => Carbon::now()->addDay()->addHour()->toDateTimeString(),
            'description' => 'New description',
        ]);

        $response->assertNoContent();

        $reservation->refresh();

        $this->assertEquals('New description', $reservation->getDescription());
    }

    public function test_reservation_update_not_found(): void
    {
        $user = UserFactory::new()->createOne();

        $reservation = ReservationFactory::new()->for(UserFactory::new())->createOne();

        Sanctum::actingAs($user);

        $response = $this->putJson(URL::action(ReservationShowController::class, ['id' => $reservation->getId()]), [
            'start_at' => Carbon::now()->addDay()->toDateTimeString(),
            'end_at' => Carbon::now()->addDay()->addHour()->toDateTimeString(),
            'description' => 'New description',
        ]);

        $response->assertNotFound();
    }

    public function test_reservation_update_unauthenticated(): void
    {
        $reservation = ReservationFactory::new()->for(UserFactory::new())->createOne();

        $response = $this->putJson(URL::action(ReservationShowController::class, ['id' => $reservation->getId()]), [
            'start_at' => Carbon::now()->addDay()->toDateTimeString(),
            'end_at' => Carbon::now()->addDay()->addHour()->toDateTimeString(),
            'description' => 'New description',
        ]);

        $response->assertUnauthorized();
    }
}
