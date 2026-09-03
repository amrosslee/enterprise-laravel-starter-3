<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole(Role::findByName(UserRoles::Manager->value)->first());

        User::factory()->count(50)
            ->create()
            ->each(function (User $user) {
                $user->assignRole(Role::findByName(Arr::random(UserRoles::cases())));
            });
    }
}
