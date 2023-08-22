<?php

namespace Database\Seeders;

use App\Acl\Acl;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() > 0) {
            return;
        }

        $superAdmin = User::withoutEvents(function () {
            return User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@vand.jp',
                'password' => Hash::make('SuperAdmin@vand99'),
            ]);
        });

        $admin = User::withoutEvents(function () {
            return User::create([
                'name' => 'Admin',
                'email' => 'admin@nettrust.jp',
                'password' => Hash::make('Admin@vand99'),
            ]);
        });

        $staff = User::withoutEvents(function () {
            return User::create([
                'name' => 'Staff',
                'email' => 'staff@nettrust.jp',
                'password' => Hash::make('Staff@vand99'),
            ]);
        });

        $customer = User::withoutEvents(function () {
            return User::create([
                'name' => 'Customer',
                'email' => 'customer@nettrust.jp',
                'password' => Hash::make('Customer@vand99'),
            ]);
        });

        $customer2 = User::withoutEvents(function () {
            return User::create([
                'name' => 'Customer 2',
                'email' => 'customer2@nettrust.jp',
                'password' => Hash::make('Customer@vand99'),
            ]);
        });

        $superAdminRole = Role::findByName(Acl::ROLE_SUPER_ADMIN);
        $adminRole = Role::findByName(Acl::ROLE_ADMIN);
        $staffRole = Role::findByName(Acl::ROLE_STAFF);
        $customerRole = Role::findByName(Acl::ROLE_CUSTOMER);

        //Sync Roles to seed accounts
        $superAdmin->syncRoles($superAdminRole);
        $admin->syncRoles($adminRole);
        $staff->syncRoles($staffRole);
        $customer->syncRoles($customerRole);
        $customer2->syncRoles($customerRole);
    }
}
