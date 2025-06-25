<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendapatan_criteria = Criteria::create([
            'name' => 'Pendapatan',
            'category' => 'benefit',
            'weight' => 0.45,
            'table_reference' => 'loans',
            'column_reference' => 'pendapatan'
        ]);
        $this->command->info('Pendapatan criteria created successfully.');

        $this->command->info('Creating criteria scores for Pendapatan...');
        $pendapatan_criteria->scores()->createMany([
            ['batas_bawah' => 0, 'score' => 1],
            ['batas_bawah' => 2000000, 'score' => 2],
            ['batas_bawah' => 3000000, 'score' => 3],
            ['batas_bawah' => 4000000, 'score' => 4],
            ['batas_bawah' => 5000000, 'score' => 5]
        ]);

        $jaminan_criteria = Criteria::create([
            'name' => 'Jaminan',
            'category' => 'benefit',
            'weight' => 0.30,
            'table_reference' => 'loans',
            'column_reference' => 'jaminan'
        ]);
        $this->command->info('Jaminan criteria created successfully.');

        $this->command->info('Creating criteria scores for Jaminan...');
        $jaminan_criteria->scores()->createMany([
            ['batas_bawah' => 0, 'score' => 1],
            ['batas_bawah' => 4000000, 'score' => 2],
            ['batas_bawah' => 6000000, 'score' => 3],
            ['batas_bawah' => 8000000, 'score' => 4],
            ['batas_bawah' => 10000000, 'score' => 5]
        ]);


        $jumlah_tanggungan_criteria = Criteria::create([
            'name' => 'Jumlah Tanggungan',
            'category' => 'cost',
            'weight' => 0.25,
            'table_reference' => 'loans',
            'column_reference' => 'jumlah_tanggungan'
        ]);
        $this->command->info('Jumlah Tanggungan criteria created successfully.');

        $this->command->info('Creating criteria scores for Jumlah Tanggungan...');
        $jumlah_tanggungan_criteria->scores()->createMany([
            ['batas_bawah' => 0, 'score' => 5],
            ['batas_bawah' => 2, 'score' => 4],
            ['batas_bawah' => 3, 'score' => 3],
            ['batas_bawah' => 4, 'score' => 2],
            ['batas_bawah' => 5, 'score' => 1]
        ]);
    }
}
