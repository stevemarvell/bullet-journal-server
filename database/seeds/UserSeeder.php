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
            'name' => "Ms Tester",
            'email' => "tester@example.com",
            'password' => bcrypt("keepitsecret"),
        ]);

        factory(User::class, 10)->create();
    }
}
