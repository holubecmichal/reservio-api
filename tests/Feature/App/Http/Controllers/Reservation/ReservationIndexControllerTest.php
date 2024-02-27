<?php

namespace Tests\Feature\App\Http\Controllers\Reservation;

use App\Http\Controllers\Reservation\ReservationIndexController;
use App\Http\Requests\Reservation\ReservationIndexRequest;
use Database\Factories\ReservationFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReservationIndexControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_index(): void
    {
        $user = UserFactory::new()->createOne();

        ReservationFactory::new()->for($user)->createOne([
            'start_at' => Carbon::now()->addHours(1),
            'end_at' => Carbon::now()->addHours(3),
        ]);

        ReservationFactory::new()->for($user)->createOne([
            'start_at' => Carbon::now()->addWeek()->addHours(1),
            'end_at' => Carbon::now()->addWeek()->addHours(3),
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson(URL::action(ReservationIndexController::class, [
            'filter' => [
                'gte_start_at' => Carbon::now()->toDateString(),
                'lte_end_at' => Carbon::tomorrow()->toDateString(),
            ],
            'sort' => ReservationIndexRequest::SORT
        ]));

        $response->assertOk();

        $this->assertCount(1, $response->json('data'));

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'start_at',
                    'end_at',
                    'description',
                    'user' => $this->userStructure(),
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    public function test_reservation_index_unauthenticated(): void
    {
        $response = $this->getJson(URL::action(ReservationIndexController::class));

        $response->assertUnauthorized();
    }
}
