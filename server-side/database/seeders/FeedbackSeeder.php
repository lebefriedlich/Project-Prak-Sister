<?php

namespace Database\Seeders;

use App\Models\FeedbackModel;
use Carbon\Carbon;
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
                'id_pendaftaran' => 1,
                'rating' => 5,
                'komentar' => 'Mantap',
                'tanggal_feedback' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'jenis_feedback' => 'Saran'
            ],
            [
                'id_pendaftaran' => 2,
                'rating' => 4,
                'komentar' => 'Bagus',
                'tanggal_feedback' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'jenis_feedback' => 'Saran'
            ],
            [
                'id_pendaftaran' => 3,
                'rating' => 3,
                'komentar' => 'Lumayan',
                'tanggal_feedback' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'jenis_feedback' => 'Saran'
            ],
        ];

        foreach ($feedback as $data) {
            FeedbackModel::create($data);
        }
    }
}
