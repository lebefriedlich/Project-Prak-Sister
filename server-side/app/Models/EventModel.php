<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id_event';
    protected $fillable = [
        'nama_event',
        'tanggal_event',
        'deskripsi',
        'id_lokasi',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function lokasi()
    {
        return $this->belongsTo(LokasiEventModel::class, 'id_lokasi', 'id_lokasi');
    }

    public function feedback()
    {
        return $this->hasMany(FeedbackModel::class, 'id_event', 'id_event');
    }

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranModel::class, 'id_event', 'id_event');
    }
}
