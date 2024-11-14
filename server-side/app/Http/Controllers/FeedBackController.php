<?php

namespace App\Http\Controllers;

use App\Models\FeedbackModel;
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
            'id_user' => 'required|exists:users,id_user',
            'id_event' => 'required|exists:events,id_event',
            'rating' => 'required|in:1,2,3,4,5',
            'komentar' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $existingFeedback = FeedBackModel::where('id_user', $request->id_user)
            ->where('id_event', $request->id_event)
            ->first();

        if ($existingFeedback) {
            return response()->json([
                'status_code' => 201,
                'message' => 'Anda sudah memberikan feedback untuk event ini'
            ], 201);
        }

        $feedback = FeedBackModel::create([
            'id_user' => $request->id_user,
            'id_event' => $request->id_event,
            'rating' => $request->rating,
            'komentar' => $request->komentar
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
