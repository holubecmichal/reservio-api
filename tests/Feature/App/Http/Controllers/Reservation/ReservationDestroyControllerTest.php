<?php

namespace Tests\Feature\App\Http\Controllers\Reservation;

use App\Http\Controllers\Reservation\ReservationDestroyController;
use Database\Factories\ReservationFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReservationDestroyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_destroy(): void
    {
        Notification::fake();

        $user = UserFactory::new()->createOne();

        $reservation = ReservationFactory::new()->for($user)->createOne();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(URL::action(ReservationDestroyController::class, ['id' => $reservation->getId()]));

        $response->assertNoContent();

        Notification::assertSentTo($user, \App\Notifications\ReservationCanceledNotification::class);
    }

    public function test_reservation_destroy_not_found(): void
    {
        Notification::fake();

        $user = UserFactory::new()->createOne();

        $reservation = ReservationFactory::new()->for(UserFactory::new())->createOne();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(URL::action(ReservationDestroyController::class, ['id' => $reservation->getId()]));

        $response->assertNotFound();

        Notification::assertNothingSent();
    }

    public function test_reservation_destroy_unauthenticated(): void
    {
        Notification::fake();

        $reservation = ReservationFactory::new()->for(UserFactory::new())->createOne();

        $response = $this->deleteJson(URL::action(ReservationDestroyController::class, ['id' => $reservation->getId()]));

        $response->assertUnauthorized();

        Notification::assertNothingSent();
    }
}
