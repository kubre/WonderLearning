<?php

namespace Database\Factories;

use App\Models\Admission;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'admission_at' => now()->format('Y-m-d'),
            'program' => $this->faker->randomElement(['Nursery', 'Playgroup', 'Junior KG', 'Senior KG']),
            'discount' => rand(0, 1000),
            'batch' => $this->faker->randomElement(['Morning', 'Afternoon']),
            'is_transportation_required' => $this->faker->boolean,
            'created_at' => now()->format('Y-m-d'),
            'school_id' => rand(1, 100),
            'student_id' => rand(1, 500),
        ];
    }
}
