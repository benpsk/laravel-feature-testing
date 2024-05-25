<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class
        ]);

        User::factory()
            ->count(5)
            ->has(
                Post::factory()->count(45)
                    ->state(new Sequence(
                        fn () => ['category_id' => Category::all()->random()->id],
                    ))
            )
            ->create();
    }
}
