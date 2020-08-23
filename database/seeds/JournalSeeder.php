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

        $me = User::firstWhere('email', "tester@example.com");

        if ($me) {

            $year = 2019;

            $me->journals()->create([

                'code' => "A",
                'title' => $me->name . " Year " . $year,

                'started_at' => "$year-01-01",
                'completed_at' => "$year-12-20",

                'user_id' => $me->id,
            ]);

            $year++;

            $me->journals()->create([

                'code' => "B",
                'title' => $me->name . " Year " . $year,

                'started_at' => "$year-01-10",
                'completed_at' => null,
            ]);
        }

        $maxJournals = 3;

        foreach (User::all() as $user) {

            if ($user == $me) continue;

            $completedStatus = true;
            $count = 0;

            while($completedStatus && $count < $maxJournals) {

                if (rand(0,9) < 3) break;

                $journal = factory(Journal::class)->create();

                $user->journals()->save($journal);

                $completedStatus = $journal->isCompleted();
            }

        }
    }
}
