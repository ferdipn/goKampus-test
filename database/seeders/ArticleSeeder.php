<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::create([
            'title' => 'This is title of content',
            'creator' => 1,
            'content' => '<p>This is body of content</p>',
            'image_url' => 'https://dummyimage.com/250/ffffff/000000'
        ]);
    }
}
