<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RekonKas;
use Illuminate\Database\Seeder;

class RekonKasSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan ada User dulu (Owner & Karyawan)
        // Kita ambil semua user yang ada, atau buat baru jika kosong
        if (User::count() == 0) {
            User::factory(3)->create();
        }

        $users = User::all();

        // 2. Loop setiap user untuk dibuatkan data rekon dummy
        foreach ($users as $user) {
            RekonKas::factory(5)->create([
                'created_by' => $user->id,
                'rekon_date' => now()->subDays(rand(1, 30)), // Tanggal acak 1 bulan terakhir
            ]);
        }
    }
}
