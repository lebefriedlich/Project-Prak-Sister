<?php

namespace App\Http\Controllers;

use App\Models\LokasiEventModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LokasiEventController extends Controller
{
    public function index()
    {
        $lokasi_event = LokasiEventModel::all();

        return response()->json([
            'status_code' => 200,
            'message' => 'Data lokasi event berhasil diambil',
            'data' => $lokasi_event
        ], 200);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi',
            'integer' => 'Kolom :attribute harus berupa angka'
        ];

        $validator = Validator::make($request->all(), [
            'nama_lokasi' => 'required',
            'gedung' => 'required',
            'kapasitas' => 'required|integer',
            'tipe_lokasi' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 401);
        }

        LokasiEventModel::create($request->all());

        return response()->json([
            'status_code' => 201,
            'message' => 'Data lokasi event berhasil ditambahkan'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $lokasi_event = LokasiEventModel::find($id);

        if (!$lokasi_event) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Data lokasi event tidak ditemukan'
            ], 404);
        }

        $messages = [
            'required' => 'Kolom :attribute harus diisi',
            'integer' => 'Kolom :attribute harus berupa angka'
        ];

        $validator = Validator::make($request->all(), [
            'nama_lokasi' => 'required',
            'gedung' => 'required',
            'kapasitas' => 'required|integer',
            'tipe_lokasi' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 401);
        }

        $lokasi_event->update($request->all());

        return response()->json([
            'status_code' => 200,
            'message' => 'Data lokasi event berhasil diupdate'
        ], 200);
    }

    public function destroy($id)
    {
        $lokasi_event = LokasiEventModel::find($id);

        if (!$lokasi_event) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Data lokasi event tidak ditemukan'
            ], 404);
        }

        $lokasi_event->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'Data lokasi event berhasil dihapus'
        ], 200);
    }
}
