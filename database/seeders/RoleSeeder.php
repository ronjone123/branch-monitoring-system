<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['code' => 'super_admin'],
            [
                'name' => 'Super Admin',
                'description' => 'Full system access',
                'status' => 'active',
            ]
        );

        Role::updateOrCreate(
            ['code' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Operational admin access',
                'status' => 'active',
            ]
        );

        Role::updateOrCreate(
            ['code' => 'importer'],
            [
                'name' => 'Importer',
                'description' => 'Can upload, preview, parse, and review imports',
                'status' => 'active',
            ]
        );

        Role::updateOrCreate(
            ['code' => 'viewer'],
            [
                'name' => 'Viewer',
                'description' => 'Read-only dashboard and summary access',
                'status' => 'active',
            ]
        );
    }
}