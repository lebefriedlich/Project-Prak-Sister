<?php

namespace Database\Seeders;

use App\Models\EventModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = [
            [
                'nama_event' => 'Seminar Nasional',
                'tanggal_event' => '2024-12-12',
                'id_lokasi' => 1,
                'deskripsi' => 'Seminar Nasional yang diadakan oleh Fakultas Saintek',
                'status' => 'Dibuka',
            ],
            [
                'nama_event' => 'Seminar Internasional',
                'tanggal_event' => '2024-11-20',
                'id_lokasi' => 2,
                'deskripsi' => 'Seminar Internasional yang diadakan oleh Fakultas Saintek',
                'status' => 'Dibuka',
            ],
            [
                'nama_event' => 'Workshop Nasional',
                'tanggal_event' => '2025-02-10',
                'id_lokasi' => 3,
                'deskripsi' => 'Workshop Nasional yang diadakan oleh Fakultas Soshum',
                'status' => 'Dibuka',
            ],
            [
                'nama_event' => 'Workshop Internasional',
                'tanggal_event' => '2025-03-15',
                'id_lokasi' => 4,
                'deskripsi' => 'Workshop Internasional yang diadakan oleh Fakultas Soshum',
                'status' => 'Dibuka',
            ],
            [
                'nama_event' => 'Seminar Kewirausahaan',
                'tanggal_event' => '2025-04-20',
                'id_lokasi' => 6,
                'deskripsi' => 'Seminar Kewirausahaan yang diadakan oleh Fakultas Ekonomi',
                'status' => 'Dibuka',
            ],
            [
                'nama_event' => 'Seminar Pendidikan',
                'tanggal_event' => '2025-06-30',
                'id_lokasi' => 6,
                'deskripsi' => 'Seminar Pendidikan yang diadakan oleh Fakultas Ilmu Pendidikan',
                'status' => 'Dibuka',
            ],
            [
                'nama_event' => 'Seminar Teknologi',
                'tanggal_event' => '2025-07-05',
                'id_lokasi' => 2,
                'deskripsi' => 'Seminar Teknologi yang diadakan oleh Fakultas Teknik',
                'status' => 'Dibuka',
            ]
        ];

        foreach ($event as $e) {
            EventModel::create($e);
        }
    }
}
