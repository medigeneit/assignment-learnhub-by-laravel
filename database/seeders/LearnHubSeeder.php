<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LearnHubSeeder extends Seeder
{
    /**
     * Seed categories, courses and lessons from database/data/learnhub.json.
     */
    public function run(): void
    {
        $data = json_decode(File::get(database_path('data/learnhub.json')), true);
        $now = now();

        foreach ($data['categories'] as $category) {
            DB::table('categories')->insert([
                'id' => $category['id'],
                'name' => $category['name'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($data['courses'] as $course) {
            DB::table('courses')->insert([
                'id' => $course['id'],
                'category_id' => $course['categoryId'],
                'title' => $course['title'],
                'instructor' => $course['instructor'],
                'short_summary' => $course['shortSummary'],
                'description' => $course['description'],
                'price' => $course['price'],
                'rating' => $course['rating'],
                'duration_minutes' => $course['durationMinutes'],
                'thumbnail' => $course['thumbnail'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($data['lessons'] as $lesson) {
            DB::table('lessons')->insert([
                'id' => $lesson['id'],
                'course_id' => $lesson['courseId'],
                'title' => $lesson['title'],
                'duration_minutes' => $lesson['durationMinutes'],
                'sort_order' => $lesson['order'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
