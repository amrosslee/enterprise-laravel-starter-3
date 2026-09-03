<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::query()->inRandomOrder()->first()->id,
            'name' => $this->faker->word,
            'path' => $this->faker->filePath,
        ];
    }
}
