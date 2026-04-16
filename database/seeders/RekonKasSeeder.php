<?php

namespace Database\Seeders;

use App\Models\RekonKas;
use App\Models\User;
use Illuminate\Database\Seeder;

class RekonKasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first();

        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Admin Rekon',
                'email' => 'adminrekon@example.com',
            ]);
        }

        RekonKas::factory()
            ->count(20)
            ->create([
                'created_by' => $user->id,
            ]);
    }
}