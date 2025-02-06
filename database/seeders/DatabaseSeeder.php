<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(SourcesTableSeeder::class);

        // / Seed Authors
        \App\Models\Author::factory(10)->create();
        $this->command->info('✅ Authors seeded successfully.');

        // Seed Categories
        \App\Models\Category::factory(5)->create();
        $this->command->info('✅ Categories seeded successfully.');

        // Seed Sources
        \App\Models\Source::factory(7)->create();
        $this->command->info('✅ Sources seeded successfully.');

        // Seed Articles
        \App\Models\Article::factory(50)->create();
        $this->command->info('✅ Articles seeded successfully.');
    }
}
