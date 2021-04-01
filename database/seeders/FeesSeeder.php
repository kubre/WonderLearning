<?php

namespace Database\Seeders;

use App\Models\Fees;
use Illuminate\Database\Seeder;

class FeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fees::factory()->count(100)->create();
    }
}
