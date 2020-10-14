<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Muhammad Agiel Nugraha',
            'email' => 'agielnara17@gmail.com',
            'nomor_hp' => '+6285819910714',
            'photo' => 'img/profile/default.png',
            'api_token' => Str::random(60),
        ]);
    }
}
