<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user_value = [
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ];

        DB::beginTransaction();

        $staff = User::create(array_merge([
            'email' => 'staff@gmail.com',
            'name' => 'staff',
            'hrd_id' => '1',
        ], $default_user_value));

        $spv = User::create(array_merge([
            'email' => 'spv@gmail.com',
            'name' => 'spv',
            'hrd_id' => '2',
        ], $default_user_value));

        $manager = User::create(array_merge([
            'email' => 'manager@gmail.com',
            'name' => 'manager',
            'hrd_id' => '3',
        ], $default_user_value));

        $it = User::create(array_merge([
            'email' => 'it@gmail.com',
            'name' => 'it',
            'hrd_id' => '4',
        ], $default_user_value));
        $role_staff = Role::create(['name' => 'staff']);
        $role_spv = Role::create(['name' => 'spv']);
        $role_manager = Role::create(['name' => 'manager']);
        $role_it = Role::create(['name' => 'it']);
        $role_NSMT = Role::create(['name' => 'NSMT']);

        $permission = Permission::create(['name' => 'read role']);
        $permission = Permission::create(['name' => 'create role']);
        $permission = Permission::create(['name' => 'update role']);
        $permission = Permission::create(['name' => 'delete role']);


        $role_it->givePermissionTo('read role');
        $role_it->givePermissionTo('create role');
        $role_it->givePermissionTo('update role');
        $role_it->givePermissionTo('delete role');

        $role_manager->givePermissionTo('read role');
        $role_manager->givePermissionTo('create role');
        $role_manager->givePermissionTo('update role');
        $role_manager->givePermissionTo('delete role');

        $role_NSMT->givePermissionTo('read role');
        $role_NSMT->givePermissionTo('create role');
        $role_NSMT->givePermissionTo('update role');
        $role_NSMT->givePermissionTo('delete role');


        $staff->assignRole('staff');
        $spv->assignRole('spv');
        $manager->assignRole('manager');
        $it->assignRole('it');

        DB::commit();
    }
}
