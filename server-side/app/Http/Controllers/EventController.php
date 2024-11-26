<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $event = EventModel::with('lokasi')
            ->orderBy('tanggal_event', 'asc')
            ->take(6)
            ->get();

        return response()->json([
            'status_code' => 200,
            'message' => 'Data event berhasil diambil',
            'data' => $event,
        ], 200);
    }

    public function showRegistFeedback(){
        $event = EventModel::with('lokasi')
            ->with('pendaftaran.user')
            ->with('pendaftaran.feedback')
            ->orderBy('tanggal_event', 'asc')
            ->get();

        return response()->json([
            'status_code' => 200,
            'message' => 'Data event berhasil diambil',
            'data' => $event,
        ], 200);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'exists' => 'Kolom :attribute tidak ditemukan.',
            'date' => 'Kolom :attribute harus berupa tanggal.',
            'in' => 'Kolom :attribute harus salah satu dari: :values',
        ];

        $validator = Validator::make($request->all(), [
            'id_lokasi' => 'required|exists:lokasi_event,id_lokasi',
            'nama_event' => 'required',
            'tanggal_event' => 'required|date',
            'deskripsi' => 'required',
            'status' => 'required|in:Dibuka,Ditutup',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 401);
        }

        $existingEvent = EventModel::where('id_lokasi', $request->id_lokasi)
            ->where('tanggal_event', $request->tanggal_event)
            ->exists();

        if ($existingEvent) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Event sudah dibooking pada tanggal tersebut untuk lokasi ini.',
            ], 200);
        }

        EventModel::create($request->all());

        return response()->json([
            'status_code' => 201,
            'message' => 'Data event berhasil ditambahkan',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'exists' => 'Kolom :attribute tidak ditemukan.',
            'date' => 'Kolom :attribute harus berupa tanggal.',
            'in' => 'Kolom :attribute harus salah satu dari: :values',
        ];

        $validator = Validator::make($request->all(), [
            'id_lokasi' => 'required|exists:lokasi_event,id_lokasi',
            'nama_event' => 'required',
            'tanggal_event' => 'required|date',
            'deskripsi' => 'required',
            'status' => 'required|in:Dibuka,Ditutup',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 401);
        }

        $event = EventModel::find($id);

        if ($event) {
            $event->update($request->all());

            return response()->json([
                'status_code' => 200,
                'message' => 'Data event berhasil diubah',
            ], 200);
        } else {
            return response()->json([
                'status_code' => 404,
                'message' => 'Data event tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $event = EventModel::find($id);

        if ($event) {
            $event->delete();

            return response()->json([
                'status_code' => 200,
                'message' => 'Data event berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'status_code' => 404,
                'message' => 'Data event tidak ditemukan',
            ], 404);
        }
    }
}
