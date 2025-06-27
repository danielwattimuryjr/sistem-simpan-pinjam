<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\User;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Loan::query()->delete();

        $user = User::first() ?? User::factory()->create();

        Loan::create([
            'user_id' => $user->id,
            'pendapatan' => 5000000,
            'jumlah_tanggungan' => 2,
            'jaminan' => 10000000,
            'jumlah_pinjaman' => 15000,
            'status' => 'pending',
        ]);

        Loan::create([
            'user_id' => $user->id,
            'pendapatan' => 3000000,
            'jumlah_tanggungan' => 4,
            'jaminan' => 7000000,
            'jumlah_pinjaman' => 20000,
            'status' => 'pending',
        ]);

        Loan::create([
            'user_id' => $user->id,
            'pendapatan' => 4000000,
            'jumlah_tanggungan' => 3,
            'jaminan' => 8000000,
            'jumlah_pinjaman' => 20000,
            'status' => 'pending',
        ]);
    }
}
