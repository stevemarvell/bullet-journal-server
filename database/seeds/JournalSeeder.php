<?php

use App\Journal;
use App\User;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Journal::truncate();

        $me = User::firstWhere('email',"behat.tester@example.com");

        if ($me) {

            $year = 2019;

            Journal::create([

                'index' => "A",
                'title' => $me->name . " Year " . $year,

                'started_at' => "$year-01-01",
                'completed_at' => "$year-12-20",

                'user_id' => $me->id,
            ]);

            $year++;

            Journal::create([

                'index' => "B",
                'title' => $me->name . " Year " . $year,

                'started_at' => "$year-01-10",
                'completed_at' => null,

                'user_id' => $me->id,
            ]);
        }

        factory(Journal::class, 30)->create();
    }
}
