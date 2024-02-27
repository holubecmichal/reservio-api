<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\MeController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_me(): void
    {
        $user = UserFactory::new()->createOne();

        Sanctum::actingAs($user);

        $response = $this->getJson(URL::action(MeController::class));

        $response->assertOk();

        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ]);
    }

    public function test_me_unauthenticated(): void
    {
        $response = $this->getJson(URL::action(MeController::class));

        $response->assertUnauthorized();
    }
}
