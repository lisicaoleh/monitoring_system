<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            [
                'id' => '1',
                'name' => 'engineer'
            ],
            [
                'id' => '2',
                'name' => 'main engineer'
            ],
            [
                'id' => '3',
                'name' => 'manager'
            ]
        ]);
    }
}
