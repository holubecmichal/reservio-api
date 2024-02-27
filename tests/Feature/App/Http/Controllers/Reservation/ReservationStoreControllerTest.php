<?php

namespace Tests\Feature\App\Http\Controllers\Reservation;

use App\Http\Controllers\Reservation\ReservationStoreController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReservationStoreControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_store(): void
    {
        $user = UserFactory::new()->createOne();

        Sanctum::actingAs($user);

        $response = $this->postJson(URL::action(ReservationStoreController::class), [
            'start_at' => now()->addDay()->toDateTimeString(),
            'end_at' => now()->addDay()->addHour()->toDateTimeString(),
            'description' => 'description',
        ]);

        $response->assertCreated();

        $response->assertJsonStructure($this->reservationShowStructure());
    }

    public function test_reservation_store_unauthenticated(): void
    {
        $response = $this->postJson(URL::action(ReservationStoreController::class), [
            'start_at' => now()->addDay()->toDateTimeString(),
            'end_at' => now()->addDay()->addHour()->toDateTimeString(),
            'description' => 'description',
        ]);

        $response->assertUnauthorized();
    }

    public function test_reservation_store_validation_failed(): void
    {
        $user = UserFactory::new()->createOne();

        Sanctum::actingAs($user);

        $response = $this->postJson(URL::action(ReservationStoreController::class), [
            'start_at' => now()->addDay()->toDateTimeString(),
            'end_at' => now()->addDay()->subHour()->toDateTimeString(),
            'description' => 'description',
        ]);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'errors'
        ]);
    }
}
