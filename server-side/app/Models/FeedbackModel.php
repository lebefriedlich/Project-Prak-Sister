<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    use HasFactory;

    protected $table = 'feedback';
    protected $primaryKey = 'id_feedback';
    protected $fillable = [
        'id_pendaftaran',
        'komentar',
        'rating',
        'tanggal_feedback',
        'jenis_feedback'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranModel::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}