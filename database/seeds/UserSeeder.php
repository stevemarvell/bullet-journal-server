<?php

use App\User;
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
        User::truncate();

        User::create([
            'name' => "Behat Tester",
            'email' => "behat.tester@example.com",
            'password' => bcrypt("behatpassword"),
        ]);

        factory(User::class, 10)->create();
    }
}
