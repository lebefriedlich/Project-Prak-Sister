<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiEventModel extends Model
{
    use HasFactory;

    protected $table = 'lokasi_event';
    protected $primaryKey = 'id_lokasi';
    protected $fillable = [
        'nama_lokasi',
        'gedung',
        'kapasitas',
        'tipe_lokasi'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function event()
    {
        return $this->hasMany(EventModel::class, 'id_lokasi', 'id_lokasi');
    }
}
