<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'photo' => '/storage/2021/03/30/9c0b1fd43226f2879828684a463b9fd7cbc8e9b6.png',
            'dob_at' => $this->faker->dateTimeThisDecade,
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Transgender', 'Other']),
            'code' => $this->faker->unique()->numberBetween(0, 9999),
            'father_name' => $this->faker->name,
            'father_contact' => '1489090909',
            'father_occupation' => $this->faker->jobTitle,
            'father_email' => $this->faker->unique()->email,
            'mother_name' => $this->faker->name,
            'mother_contact' => '2489090909',
            'mother_occupation' => $this->faker->jobTitle,
            'mother_email' => $this->faker->unique()->email,
            'previous_school' => $this->faker->company,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->randomNumber(6),
            'nationality' => $this->faker->country,
            'school_id' => rand(1, 100),
        ];
    }
}
