<?php

namespace Database\Factories;

use App\Models\Enquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnquiryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Enquiry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Transgender', 'Other']),
            'dob_at' => $this->faker->dateTimeThisYear,
            'program' => $this->faker->randomElement(['Nursery', 'Playgroup', 'Junior KG', 'Senior KG']), 'enquirer_name' => $this->faker->name,
            'enquirer_email' => $this->faker->unique()->email,
            'enquirer_contact' => '1489090909',
            'locality' => 'Indian',
            'reference' => 'NO',
            'follow_up_at' => now()->format('Y-m-d'),
            'student_id' => rand(1, 500),
            'school_id' => rand(1, 100),
        ];
    }
}
