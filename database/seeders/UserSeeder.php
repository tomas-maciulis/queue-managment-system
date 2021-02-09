<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->email = 'john.doe@example.net';
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // hash for word 'password'
        $user->name = 'John';
        $user->surname = 'Doe';
        $user->room = 123;
        $user->role = 'specialist';
        $user->is_available = False;
        $user->save();

        $user = new User();
        $user->email = 'jane.doe@example.net';
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // hash for word 'password'
        $user->name = 'Jane';
        $user->surname = 'Doe';
        $user->room = 321;
        $user->role = 'specialist';
        $user->is_available = True;
        $user->save();

        $user = new User();
        $user->email = 'display@example.net';
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // hash for word 'password'
        $user->name = 'Display';
        $user->surname = '-';
        $user->room = '-';
        $user->role = 'display';
        $user->is_available = False;
        $user->save();
    }
}
