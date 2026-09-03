<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $managers = User::role(UserRoles::Manager->value)->pluck('id');
        return [
            'title' => $this->faker->streetName . " - " . $this->faker->city,
            'description' => $this->faker->text(1600),
            'start_date' => $this->faker->date(),
            'deadline' => $this->faker->date(),
            'status' => $this->faker->boolean(75),
            'company_id' => Company::query()->inRandomOrder()->first()->id,
            'owner_id' => $managers->random(),
        ];
    }
}
