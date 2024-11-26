<?php

namespace App\Http\Controllers;

use App\Models\FeedbackModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedBackController extends Controller
{

    public function createFeedBack(Request $request)
    {
        $messages = [
            'required' => ':attribute harus diisi',
            'in' => ':attribute harus salah satu dari: :values',
            'exists' => ':attribute tidak ditemukan'
        ];

        $validator = Validator::make($request->all(), [
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'rating' => 'required|in:1,2,3,4,5',
            'komentar' => 'required',
            'jenis_feedback' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $existingFeedback = FeedBackModel::where('id_pendaftaran', $request->id_pendaftaran)
            ->first();

        if ($existingFeedback) {
            return response()->json([
                'status_code' => 201,
                'message' => 'Anda sudah memberikan feedback untuk event ini'
            ], 201);
        }

        $request->merge([
            'tanggal_feedback' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ]);

        $feedback = FeedBackModel::create([
            'id_pendaftaran' => $request->id_pendaftaran,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'tanggal_feedback' => $request->tanggal_feedback,
            'jenis_feedback' => $request->jenis_feedback
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Feedback berhasil ditambahkan',
            'data' => $feedback
        ], 200);
    }

    public function deleteFeedBack(Request $request)
    {
        $messages = [
            'required' => ':attribute harus diisi',
            'array' => ':attribute harus berupa array',
            'exists' => ':attribute tidak ditemukan'
        ];

        $validator = Validator::make($request->all(), [
            'id_feedback' => 'required|array',
            'id_feedback.*' => 'exists:feedback,id_feedback'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        foreach ($request->id_feedback as $id_feedback) {
            $feedback = FeedBackModel::find($id_feedback);
            $feedback->delete();
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'Feedback berhasil dihapus',
        ], 200);
    }
}
