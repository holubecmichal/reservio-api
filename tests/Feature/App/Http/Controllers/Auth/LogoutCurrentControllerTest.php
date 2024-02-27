<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LogoutCurrentController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutCurrentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_current(): void
    {
        $user = UserFactory::new()->createOne();

        Sanctum::actingAs($user);

        $response = $this->postJson(URL::action(LogoutCurrentController::class));

        $response->assertOk();
    }

    public function test_logout_current_unauthenticated(): void
    {
        $response = $this->postJson(URL::action(LogoutCurrentController::class));

        $response->assertUnauthorized();
    }
}
