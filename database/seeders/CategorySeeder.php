<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['PHP', 'Laravel', 'JavaScript'];
        Category::factory()
            ->count(3)
            ->sequence(fn (Sequence $sequence) => ['name' =>  $names[$sequence->index]])
            ->create();
    }
}
