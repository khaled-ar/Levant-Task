<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\{
    User,
    Post,
    Comment
};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(500)->create();
        Post::factory(400)->create();
        Comment::factory(1000)->create();
    }
}
