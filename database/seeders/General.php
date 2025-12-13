<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class General extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $exams = [];
        for ($i = 0; $i < 10; $i++) {
            $exams[] = [
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'start_time' => $faker->dateTimeBetween('+1 days', '+10 days'),
                'end_time' => $faker->dateTimeBetween('+11 days', '+20 days'),
                'duration_minutes' => $faker->numberBetween(30, 180), // in minutes
                'total_marks' => $faker->numberBetween(50, 100),
                'created_by' => 'admin', // placeholder
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('exams')->insert($exams);

        $examIds = DB::table('exams')->pluck('id');

        $questions = [];
        foreach ($examIds as $examId) {
            for ($j = 0; $j < 100; $j++) {
                $questions[] = [
                    'exam_id' => $examId,
                    'question_text' => $faker->sentence(10),
                    'question_type' => 'multiple_choice', // for simplicity
                    'options' => json_encode([
                        'A' => $faker->word,
                        'B' => $faker->word,
                        'C' => $faker->word,
                        'D' => $faker->word,
                    ]),
                    'correct_answer' => $faker->randomElement(['A', 'B', 'C', 'D']),
                    'marks' => $faker->numberBetween(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('exam_questions')->insert($questions);

    }
}
