<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Super admin
        $superadmin = new User;
        $superadmin->username = 'super.admin';
        $superadmin->fullname = 'Super Admin';
        $superadmin->email = 'super.admin@gmail.com';
        $superadmin->password = bcrypt("masuk");
        $superadmin->role = User::ROLE_SUPERMIN;
        $superadmin->status = User::STATUS_ACTIVE;
        $superadmin->save();
        
        //  Admin
        $admin = new User;
        $admin->username = 'admin';
        $admin->fullname = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt("masuk");
        $admin->role = User::ROLE_ADMIN;
        $admin->status = User::STATUS_ACTIVE;
        $admin->save();
    }
}
