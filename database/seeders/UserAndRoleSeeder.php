<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a user
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'cnic' => '5544332211',
            'image' => ''
        ]);

        $role = Role::create([
            'name' => 'Admin'
        ]);

        $permissions = [
            'roles-list',
            'roles-create',
            'roles-edit',
            'roles-delete',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'contacts-view'
        ];
        $role->syncPermissions($permissions);
        // Assign a role to the user
        $role = Role::where('name', 'Admin')->first();
        if ($role) {
            $user->assignRole($role);
        }
    }
}
