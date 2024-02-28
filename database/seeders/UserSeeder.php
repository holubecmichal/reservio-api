<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment(['staging', 'production'])) {
            return;
        }

        if (User::query()->getQuery()->exists()) {
            return;
        }

        UserFactory::new()->create([
            'email' => 'testovaci@user.cz',
            'password' => Hash::make('password'),
        ]);
    }
}
