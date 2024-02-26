<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login(): void
    {
        $user = UserFactory::new()->createOne();

        $response = $this->postJson(URL::action(LoginController::class), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'token'
        ]);

        $this->assertDatabaseCount('personal_access_tokens', 1);
    }

    public function test_login_failed(): void
    {
        $user = UserFactory::new()->createOne();

        $response = $this->postJson(URL::action(LoginController::class), [
            'email' => $user->email,
            'password' => 'unkown',
        ]);

        $response->assertUnauthorized();

        $response->assertJsonStructure([
            'errors'
        ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
