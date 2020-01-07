<?php

use App\Author;
use App\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory(Profile::class , 20)->create()->each(function ($author_id) {
				$author_id->posts()->save(factory(Author::class )->make());
			});
	}
}
