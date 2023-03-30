<?php

namespace Database\Seeders;

use App\Models\Interesting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Interesting::factory(10)->create();
    }
}
