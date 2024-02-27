<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LogoutAllController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutAllControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_all(): void
    {
        $user = UserFactory::new()->createOne();

        Sanctum::actingAs($user);

        $response = $this->postJson(URL::action(LogoutAllController::class));

        $response->assertOk();
    }

    public function test_logout_all_unauthenticated(): void
    {
        $response = $this->postJson(URL::action(LogoutAllController::class));

        $response->assertUnauthorized();
    }
}
