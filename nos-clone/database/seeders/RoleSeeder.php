<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full system access'
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Standard user access'
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor',
                'description' => 'Can edit and manage content'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
