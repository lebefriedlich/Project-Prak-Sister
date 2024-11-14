<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    // method Admin
    public function updateStatus(Request $request)
    {
        $messages = [
            'required' => ':attribute harus diisi',
            'exists' => ':attribute tidak ditemukan',
            'array' => ':attribute harus berupa array',
            'in' => ':attribute harus salah satu dari: :values'
        ];

        $validator = Validator::make($request->all(), [
            'id_event' => 'required|exists:events,id_event',
            'id_user' => 'required|array',
            'id_user.*' => 'exists:users,id_user',
            'status_kehadiran' => 'required|array',
            'status_kehadiran.*' => 'in:Hadir,Tidak Hadir'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $id_event = $request->input('id_event');
        $id_users = $request->input('id_user');
        $status_kehadiran = $request->input('status_kehadiran');

        foreach ($id_users as $id_user) {
            $status = $status_kehadiran[$id_user] ?? null;

            if ($status) {
                $peserta = PendaftaranModel::where('id_event', $id_event)
                    ->where('id_user', $id_user)
                    ->first();

                if ($peserta) {
                    $peserta->status_kehadiran = $status;
                    $peserta->save();
                }
            }
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'Status peserta berhasil diubah',
        ], 200);
    }

    // method User
    public function getPendaftaranByUserid($id_user)
    {
        $peserta = PendaftaranModel::where('id_user', $id_user)
            ->with('event.feedback.user')
            ->get();

        return response()->json([
            'status_code' => 200,
            'message' => 'Data peserta berhasil diambil',
            'data' => $peserta
        ], 200);
    }

    public function daftarEvent(Request $request)
    {
        $messages = [
            'required' => ':attribute harus diisi',
            'exists' => ':attribute tidak ditemukan',
            'date' => ':attribute harus berupa tanggal',
        ];

        $validator = Validator::make($request->all(), [
            'id_event' => 'required|exists:events,id_event',
            'id_user' => 'required|exists:users,id_user',
            'tanggal_daftar' => 'required|date',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        // Mengecek apakah user sudah terdaftar di event yang sama
        $existingRegistration = PendaftaranModel::where('id_event', $request->id_event)
            ->where('id_user', $request->id_user)
            ->first();

        if ($existingRegistration) {
            return response()->json([
                'status_code' => 201,
                'message' => 'Anda sudah terdaftar untuk acara ini'
            ], 201);
        }

        // Menambahkan status kehadiran dan menyimpan data pendaftaran
        $request->merge([
            'status_kehadiran' => 'Tidak Hadir'
        ]);

        $peserta = PendaftaranModel::create($request->all());

        return response()->json([
            'status_code' => 200,
            'message' => 'Berhasil mendaftar event',
            'data' => $peserta
        ], 200);
    }
}
