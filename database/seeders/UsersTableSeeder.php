<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'super-admin'
        ]);
        $permissions = Permission::pluck('id')->toArray();
        $role->syncPermissions($permissions);

        $user = User::create([
            'name' => 'Felipe Guzman',
            'phone' => '9931809757',
            'email' => 'felipe-guzman.c@hotmail.com',
            'profile' => $role->name,
            'password' => bcrypt('secret2022')
        ]);

        $user->syncRoles($role->name);

    }
}
