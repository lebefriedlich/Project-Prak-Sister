<?php

namespace Database\Seeders;

use App\Models\LokasiEventModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LokasiEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasiEvent = [
            [
                'nama_lokasi' => 'Auditorium Selatan Saintek',
                'gedung' => 'Gedung Saintek',
                'kapasitas' => 300,
                'tipe_lokasi' => 'Indoor',
            ],
            [
                'nama_lokasi' => 'Auditorium Utara Saintek',
                'gedung' => 'Gedung Saintek',
                'kapasitas' => 300,
                'tipe_lokasi' => 'Indoor',
            ],
            [
                'nama_lokasi' => 'Auditorium Soshum',
                'gedung' => 'Gedung Soshum',
                'kapasitas' => 300,
                'tipe_lokasi' => 'Indoor',
            ],
            [
                'nama_lokasi' => 'Student Center',
                'gedung' => 'Gedung Student Center',
                'kapasitas' => 2500,
                'tipe_lokasi' => 'Indoor',
            ],
            [
                'nama_lokasi' => 'Masjid At-Tarbiyah',
                'gedung' => 'Gedung Masjid At-Tarbiyah',
                'kapasitas' => 1500,
                'tipe_lokasi' => 'Indoor',
            ],
            [
                'nama_lokasi' => 'Auditorium Rektorat',
                'gedung' => 'Gedung Rektorat',
                'kapasitas' => 300,
                'tipe_lokasi' => 'Indoor',
            ],
            [
                'nama_lokasi' => 'Lapangan Utama',
                'gedung' => 'Lapangan Utama',
                'kapasitas' => 5000,
                'tipe_lokasi' => 'Outdoor',
            ]
        ];

        foreach ($lokasiEvent as $lokasi) {
            LokasiEventModel::create($lokasi);
        }
    }
}
