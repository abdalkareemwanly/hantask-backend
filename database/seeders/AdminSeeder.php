<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'SuperAdmin','guard_name' => 'api']);
        $admin = Admin::create([
            'name' => 'mohamad',
            'username' => 'mohamad',
            'email' => 'mohamad@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 1,
            'role' => $role->name
        ]);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $admin->assignRole($role);

    }
}
