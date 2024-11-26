<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/event';
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ]
            ]);

            $body = json_decode($response->getBody());

            $apiUrl1 = config('app.api_url') . '/api/admin/lokasi-event';
            $response1 = $client->request('GET', $apiUrl1, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ]
            ]);


            $body1 = json_decode($response1->getBody());

            if ($response->getStatusCode() == 200 && $response1->getStatusCode() == 200) {
                return view('Admin.event', [
                    'datas' => $body->data,
                    'lokasi' => $body1->data,
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'date' => 'Kolom :attribute harus berupa tanggal.',
            'in' => 'Kolom :attribute harus salah satu dari: :values',
        ];

        $validator = Validator::make($request->all(), [
            'id_lokasi' => 'required',
            'nama_event' => 'required',
            'tanggal_event' => 'required|date',
            'deskripsi' => 'required',
            'status' => 'required|in:Dibuka,Ditutup',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/event';
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ],
                'form_params' => [
                    'id_lokasi' => $request->id_lokasi,
                    'nama_event' => $request->nama_event,
                    'tanggal_event' => $request->tanggal_event,
                    'deskripsi' => $request->deskripsi,
                    'status' => $request->status,
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 201) {
                return redirect()->back()->with('success', $body->message);
            } else if ($response->getStatusCode() == 200) {
                return redirect()->back()->with('error', $body->message);
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function update(Request $request, $id_event)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'date' => 'Kolom :attribute harus berupa tanggal.',
            'in' => 'Kolom :attribute harus salah satu dari: :values',
        ];

        $validator = Validator::make($request->all(), [
            'id_lokasi' => 'required',
            'nama_event' => 'required',
            'tanggal_event' => 'required|date',
            'deskripsi' => 'required',
            'status' => 'required|in:Dibuka,Ditutup',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/event/' . $id_event;
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ],
                'form_params' => [
                    'id_lokasi' => $request->id_lokasi,
                    'nama_event' => $request->nama_event,
                    'tanggal_event' => $request->tanggal_event,
                    'deskripsi' => $request->deskripsi,
                    'status' => $request->status,
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                return redirect()->back()->with('success', $body->message);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function destroy($id_event)
    {
        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/event/' . $id_event;
            $response = $client->request('DELETE', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                return redirect()->back()->with('success', $body->message);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function setKehadiran(Request $request)
    {
        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/pendaftaran';
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ],
                'form_params' => [
                    'id_event' => $request->id_event,
                    'id_user' => $request->id_user,
                    'status_kehadiran' => $request->status_kehadiran,
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                return redirect()->back()->with('success', $body->message);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.' . $e->getMessage());
        }
    }

    public function deleteFeedback(Request $request)
    {
        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/feedback';
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ],
                'form_params' => [
                    'id_feedback' => $request->id_feedback,
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                return redirect()->back()->with('success', $body->message);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }
}
