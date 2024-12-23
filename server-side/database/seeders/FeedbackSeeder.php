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
                'komentar' => 'Materinya menarik, tapi sesi diskusi kurang lebih lama.',
                'tanggal_feedback' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'jenis_feedback' => 'Saran'
            ],
            [
                'id_pendaftaran' => 2,
                'rating' => 5,
                'komentar' => 'Acara sangat inspiratif, terima kasih panitia!',
                'tanggal_feedback' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'jenis_feedback' => 'Saran'
            ],
            [
                'id_pendaftaran' => 3,
                'rating' => 5,
                'komentar' => 'Bagus, mungkin tambah demo langsung akan lebih seru.',
                'tanggal_feedback' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'jenis_feedback' => 'Saran'
            ],
        ];

        foreach ($feedback as $data) {
            FeedbackModel::create($data);
        }
    }
}
