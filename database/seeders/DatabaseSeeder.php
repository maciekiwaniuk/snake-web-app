<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VisitorUnique;
use App\Models\UserGameData;
use App\Models\Hosting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::query()
            ->get();

        $user1234_exists = false;
        $test1234_exists = false;
        $admin1234_exists = false;

        foreach ($users as $user) {
            if ($user['name'] == "user1234") {
                $user1234_exists = true;
            }
            if ($user['name'] == "test1234") {
                $test1234_exists = true;
            }
            if ($user['name'] == "admin1234") {
                $admin1234_exists = true;
            }
        }

        if ($user1234_exists == false) {
            User::factory()->create([
                'name' => "user1234",
                'email' => "user1234@wp.pl",
                'password' => Hash::make("user1234"),
                'permission' => 0,
            ]);
        }

        if ($test1234_exists == false) {
            User::factory()->create([
                'name' => "test1234",
                'email' => "test1234@wp.pl",
                'password' => Hash::make("test1234"),
                'permission' => 0,
            ]);
        }

        if ($admin1234_exists == false) {
            User::factory()->create([
                'name' => "admin1234",
                'email' => "admin1234@wp.pl",
                'password' => Hash::make("admin1234"),
                'permission' => 2,
            ]);
        }

        // Creating users inside VisitorUniqueFactory
        VisitorUnique::factory(50)->create();

        UserGameData::factory(53)->create();

        Hosting::factory()->create([
            'hosting_name' => "Snake (instalka)",
            'hosting_link' => "https://snake-gra.pl/pobierz-gre",
        ]);

        Hosting::factory()->create([
            'hosting_name' => "Snake (pliki)",
            'hosting_link' => "https://snake-gra.pl/pobierz-gre",
        ]);
    }
}
