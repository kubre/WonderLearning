<?php

namespace Database\Seeders;

use App\Models\Admission;
use Illuminate\Database\Seeder;

class AdmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admission::factory()->count(500)->create();
    }
}
