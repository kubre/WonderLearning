<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = School::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->company;
        return [
            'name' => $name,
            'code' => $this->faker->unique()->numberBetween(100, 999),
            'logo' => '/storage/2021/03/30/9c0b1fd43226f2879828684a463b9fd7cbc8e9b6.png',
            'contact' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->unique()->email,
            'address' => $this->faker->address,
            'academic_year' => '01-08:31:07',
            'login_url' => Str::slug($name),
        ];
    }
}
