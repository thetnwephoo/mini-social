<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // အနည္းဆံုးေတာ့ user တစ္ေယာက္ကို seed လုပ္ခ်င္တာမို့ max ကိုသံုးတာ။
        // (int) ကိုေတာ့ ရလာတဲ့ေကာင္ကို integer ေျပာင္းခ်င္တာမို့သံုးတာ။
        $userCount = max((int)$this->command->ask("How many user would you like?", 20), 1);

        factory(App\User::class)->state('john-doe')->create();
		factory(App\User::class, $userCount)->create();
    }
}
