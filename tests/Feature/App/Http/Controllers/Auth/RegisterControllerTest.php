<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register(): void
    {
        $user = UserFactory::new()->makeOne();

        $response = $this->postJson(URL::action(RegisterController::class), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    public function test_register_email_duplicity(): void
    {
        $user = UserFactory::new()->createOne();

        $response = $this->postJson(URL::action(RegisterController::class), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'errors'
        ]);
    }
}
