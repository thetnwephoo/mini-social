<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		// confirm မွာဆိုရင္ default အေနနဲ့က no ကိုေပးထားတယ္။
		if($this->command->confirm('Do you want to refresh the database?')) {
			$this->command->call('migrate:refresh');
			$this->command->info('Database was refreshed!');
		}


		$this->call(UserTableSeeder::class);
		$this->call(BlogPostSeeder::class );
		$this->call(CommentTableSeeder::class );
		// $this->call(AuthorSeeder::class );
		// $this->call(ProfileSeeder::class );
	}
}
