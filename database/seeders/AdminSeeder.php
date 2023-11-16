<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Role_Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::create([
            'name' => 'mohamad',
            'username' => 'mohamad',
            'email' => 'mohamad@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 1,
            'role' => 'SuperAdmin'
        ]);
        $role = Role::where('name','SuperAdmin')->first();
        $Permissions = Permission::all();
        foreach($Permissions as $Permission) {
            Role_Permission::create([
                'role_id' => $role->id,
                'permission_id' => $Permission->id
            ]);
        }
    }
}
