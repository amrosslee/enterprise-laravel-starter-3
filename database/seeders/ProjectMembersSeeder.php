<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::query()->whereHas('roles', function ($query) {
            $query->where('name', '!=', UserRoles::Manager->value);
        })->get();
        foreach ($projects as $project) {
            $members = $users->random(rand(1, 5));
            $project->members()->attach($members);
        }
    }
}
