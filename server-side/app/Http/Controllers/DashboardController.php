<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\LokasiEventModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $lokasi_event = LokasiEventModel::count();
        $event = EventModel::count();

        return response()->json([
            'status_code' => 200,
            'message' => 'Data dashboard berhasil diambil',
            'data' => [
                'total_lokasi_event' => $lokasi_event,
                'total_event' => $event,
            ],
        ], 200);
    }
}
