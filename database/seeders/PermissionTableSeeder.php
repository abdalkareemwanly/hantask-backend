<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard','testing','orders'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission , 'guard_name' => 'sanctum']);
        }
    }
}
