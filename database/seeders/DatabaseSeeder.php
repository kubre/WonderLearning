<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            SchoolSeeder::class,
            UserSeeder::class,
            FeesSeeder::class,
            StudentSeeder::class,
            EnquirySeeder::class,
            AdmissionSeeder::class,
        ]);

        Artisan::call('orchid:admin admin admin@admin.com password');
    }
}
