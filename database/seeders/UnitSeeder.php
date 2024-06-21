<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Buah'],
            ['name' => 'Tablet'],
            ['name' => 'Kaplet']
        ];

        foreach ($data as $each)
        {
            Unit::create($each);
        }
    }
}
