<?php

namespace Database\Seeders;

use App\Models\PendaftaranModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendaftaran = [
            [
                'id_user' => 2,
                'id_event' => 1,
                'tanggal_daftar' => Carbon::now()->format('Y-m-d'),
                'status_kehadiran' => 'Tidak Hadir'
            ], 
            [
                'id_user' => 3,
                'id_event' => 1,
                'tanggal_daftar' => Carbon::now()->format('Y-m-d'),
                'status_kehadiran' => 'Tidak Hadir'
            ],
            [
                'id_user' => 4,
                'id_event' => 1,
                'tanggal_daftar' => Carbon::now()->format('Y-m-d'),
                'status_kehadiran' => 'Tidak Hadir'
            ]
        ];

        foreach ($pendaftaran as $p) {
            PendaftaranModel::create($p);
        }
    }
}
