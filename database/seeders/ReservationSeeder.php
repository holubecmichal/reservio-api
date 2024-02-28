<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
use Database\Factories\ReservationFactory;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment(['staging', 'production'])) {
            return;
        }

        if (Reservation::query()->getQuery()->exists()) {
            return;
        }

        $user = User::query()->where('email', 'testovaci@user.cz')->first();

        ReservationFactory::new()->for($user)->count(5)->create();
    }
}
