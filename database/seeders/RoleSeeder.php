<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'editor',
            'user',
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role]);
        }
    }
}
