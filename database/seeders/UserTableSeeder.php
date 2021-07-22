<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::firstOrCreate(['id' => 1],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'middle_name' => 'S',
                'birth_date' => '12/16/1997',
                'contact_number' => '+639162330655',
                'full_address' => 'Quezon City, Philippines',
                'email' => 'super.admin@yopmail.com',
                'password' => 'Password@123',
                'account_type' => 'SuperAdmin',
                'avatar_path' => 'https://i.ytimg.com/vi/Fkz3g92wBAI/hqdefault.jpg',
            ]
        );
    }
}
