<?php

namespace Database\Factories;

use App\Models\Fees;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fees::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $school = 0;
        return [
            'title' => 'Jun 20 - May 21',
            'playgroup' => '{"1":{"fees":"Tution","amount":"10000"},"2":{"fees":"Kit","amount":"1000"}}',
            'playgroup_total' => 11000,
            'nursery' => '{"1":{"fees":"Tution","amount":"10000"},"2":{"fees":"Kit","amount":"1000"}}',
            'nursery_total' => 11000,
            'junior_kg' => '{"1":{"fees":"Tution","amount":"10000"},"2":{"fees":"Transportation","amount":"1000"}}',
            'junior_kg_total' => 11000,
            'senior_kg' => '{"1":{"fees":"Tution","amount":"10000"},"2":{"fees":"Transportation","amount":"2000"}}',
            'senior_kg_total' => 12000,
            'created_at' => now()->format('Y-m-d'),
            'school_id' => $school++,
        ];
    }
}
