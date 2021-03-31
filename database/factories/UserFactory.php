<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'permissions' => '{"fees.edit":"1","platform.index":"1","platform.systems.index":"0","admin.role":"0","admin.school":"0","admin.user":"0","platform.systems.attachment":"1","platform.systems.roles":"0","platform.systems.users":"0","admission.create":"1","admission.delete":"1","admission.edit":"1","admission.table":"1","enquiry.create":"1","enquiry.delete":"1","enquiry.edit":"1","enquiry.table":"0"}',
            'school_id' => rand(1, 100),
        ];
    }
}
