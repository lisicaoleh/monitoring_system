<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'id' => '1',
            'name' => 'engineer'
        ], [
            'id' => '2',
            'name' => 'main engineer'
        ], [
            'id' => '3',
            'name' => 'manager'
        ]);
    }
}
