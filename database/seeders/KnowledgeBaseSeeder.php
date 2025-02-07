<?php

namespace Database\Seeders;
use App\Models\Knowledge_base;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KnowledgeBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            Knowledge_base::create([
                'knowledge_base_id' => $i,
                'topic_name' => fake()->sentence(),
                'description' => fake()->paragraph()
             ]);
            }
    }
}
