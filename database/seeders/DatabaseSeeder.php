<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Feedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RoleAndPermissionSeeder::class);
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
        ])->assignRole('Admin');
        User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => bcrypt('123456'),
        ])->assignRole('Editor');
        User::factory()->create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => bcrypt('123456'),
        ])->assignRole('Author');
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('Admin');
        });
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('Editor');
        });
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('Author');
        });
        Category::factory(5)->create();
        Tag::factory(5)->create();
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();
        $articles = Article::factory(5)->create([
            'user_id' => $users->random()->id,
            'category_id' => $categories->random()->id,
        ]);
        foreach ($articles as $article) {
            $article->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        }
        Comment::factory(6)->create();
        Feedback::factory(6)->create();

    }
}
