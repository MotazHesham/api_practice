<?php

use Illuminate\Database\Seeder;
use App\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();   
        $posts = App\Post::all();
        foreach($posts as $post){
            for ($i = 1 ; $i <= 5 ; $i++) {
                $comment = new Comment;
                $comment->user_id = rand(1,10);
                $comment->post_id = $post->id;
                $comment->comment = $faker->realText($maxNbChars = 200, $indexSize = 2);
                $comment->save();
            }
        }
    }
}
