<?php

namespace Database\Seeders;

use App\Models\FeedbackModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feedback = [
            [
                'rating' => 5,
                'komentar' => 'Mantap',
                'id_user' => 2,
                'id_event' => 1
            ],
            [
                'rating' => 4,
                'komentar' => 'Bagus',
                'id_user' => 3,
                'id_event' => 1
            ],
            [
                'rating' => 3,
                'komentar' => 'Lumayan',
                'id_user' => 4,
                'id_event' => 1
            ],
        ];

        foreach ($feedback as $data) {
            FeedbackModel::create($data);
        }
    }
}
