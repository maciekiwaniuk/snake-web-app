<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VisitorUnique;
use App\Models\UserGameData;
use App\Models\GameHosting;
use App\Models\Message;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $user1234_exists = false;
        $test1234_exists = false;
        $admin1234_exists = false;

        foreach ($users as $user) {
            if ($user['name'] == 'user1234') {
                $user1234_exists = true;
            }
            if ($user['name'] == 'test1234') {
                $test1234_exists = true;
            }
            if ($user['name'] == 'admin1234') {
                $admin1234_exists = true;
            }
        }

        if ($user1234_exists == false) {
            User::factory()->create([
                'name' => 'user1234',
                'email' => 'user1234@wp.pl',
                'password' => Hash::make('user1234'),
                'permission' => User::USER_PERMISSION,
            ]);
            UserGameData::factory()->create();
        }

        if ($test1234_exists == false) {
            User::factory()->create([
                'name' => 'test1234',
                'email' => 'test1234@wp.pl',
                'password' => Hash::make('test1234'),
                'permission' => User::USER_PERMISSION,
            ]);
            UserGameData::factory()->create();
        }

        if ($admin1234_exists == false) {
            User::factory()->create([
                'name' => 'admin1234',
                'email' => 'admin1234@wp.pl',
                'password' => Hash::make('admin1234'),
                'permission' => User::ADMIN_PERMISSION,
            ]);
            UserGameData::factory()->create();
        }

        User::factory(50)->create()->each(function ($user) {
            VisitorUnique::factory(50)->create([
                'ip' => $user->last_login_ip
            ]);
            Message::factory()->create([
                'sender' => $user->name,
                'email' => $user->email,
                'content' => 'Przykładowa treść wiadomości.',
                'sent_as_user' => true,
                'user_name' => $user->name,
            ]);
        });

        UserGameData::factory(50)->create();

        GameHosting::factory()->create([
            'name' => 'Hosting',
            'link' => 'https://snake-gra.pl/pobierz-gre',
        ]);

    }
}
