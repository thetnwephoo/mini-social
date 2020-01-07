<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = App\BlogPost::all();

        if($posts->count() === 0) {
            $this->command->info("There is no post. So, there is no comments");
            return;
        }

        $commentCount = (int)$this->command->ask("How many comment would you like?", 150);

        factory(App\Comment::class, $commentCount)->make()->each(function($comment) use ($posts) {
			$comment->blog_post_id = $posts->random()->id;
			$comment->save();
		});
    }
}
