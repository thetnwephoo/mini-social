<?php

use App\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$blogPostCount = (int)$this->command->ask("How many Blog Post would you like?", 50);

		$users = App\User::all();
		
		factory(App\BlogPost::class, $blogPostCount)->make()->each(function($post) use ($users) {
			$post->user_id = $users->random()->id;
			$post->save();
		});
	}
}
