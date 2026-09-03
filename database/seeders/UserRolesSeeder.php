<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (UserRoles::cases() as $role) {
            Role::create(['name' => $role->value]);
        }
    }
}
