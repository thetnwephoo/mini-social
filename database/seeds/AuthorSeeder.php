<?php

use App\Author;
use App\Profile;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// factory(Author::class , 10)->create();
		factory(Author::class , 20)->create()->each(function ($author_id) {
				$author_id->profile()->save(factory(Profile::class )->make());
			});
	}
}
