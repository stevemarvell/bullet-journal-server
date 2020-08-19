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
            'name' => "Steve Marvell",
            'email' => "stevemarvel@crucialtechnical.com",
            'password' => bcrypt("password"),
        ]);

        factory(User::class, 10)->create();
    }
}
