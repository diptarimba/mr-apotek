<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataAdmin = [
            'name' => 'Admin',
            'username' => 'admin',
            'email' => fake()->unique()->email(),
            'phone' => '081234567890',
            'password' => bcrypt('12345678'),
            'picture' => asset('assets-dashboard/images/placeholder.png'),
        ];

        $admin = User::create($dataAdmin);
        $admin->assignRole('admin');

        // $user = User::factory(100)->create();
        // $user->each(function ($user) {
        //     $user->assignRole('user');
        // });
    }
}
