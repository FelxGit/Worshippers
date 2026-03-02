<?php
namespace Database\Seeders;

use App\Models\User;

class UserTableSeeder extends BaseSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Use the factory function within the run method
        User::factory()->create([
            'role_id' => User::NORMAL_USER,
            'username' => 'user',
            'email' => 'user@community.com',
            'password' => \Hash::make(User::PASSWORD_DEFAULT)
        ]);

        User::factory()->create([
            'role_id' => User::ADMIN_USER,
            'username' => 'admin',
            'email' => 'admin@community.com',
            'password' => \Hash::make(User::PASSWORD_DEFAULT)
        ]);
    }
}
