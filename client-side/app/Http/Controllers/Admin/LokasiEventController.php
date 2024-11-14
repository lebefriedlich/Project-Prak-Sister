<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class LokasiEventController extends Controller
{
    public function index()
    {
        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/lokasi-event';
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                return view('Admin.lokasiEvent', ['datas' => $body->data]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/lokasi-event';
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ],
                'form_params' => [
                    'nama_lokasi' => $request->nama_lokasi,
                    'gedung' => $request->gedung,
                    'kapasitas' => $request->kapasitas,
                    'tipe_lokasi' => $request->tipe_lokasi
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 201) {
                return redirect()->route('lokasi-event')->with('success', $body->message);
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function update(Request $request, $id_lokasi)
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/admin/lokasi-event/' . $id_lokasi;
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ],
                'form_params' => [
                    'nama_lokasi' => $request->nama_lokasi,
                    'gedung' => $request->gedung,
                    'kapasitas' => $request->kapasitas,
                    'tipe_lokasi' => $request->tipe_lokasi
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                return redirect()->route('lokasi-event')->with('success', $body->message);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function destroy($id_lokasi){
        $client = new Client();

        $apiUrl = config('app.api_url') . '/api/admin/lokasi-event/' . $id_lokasi;
        $response = $client->request('DELETE', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cookie::get('api_token'),
            ],
        ]);

        $body = json_decode($response->getBody());

        if ($response->getStatusCode() == 200) {
            return redirect()->route('lokasi-event')->with('success', $body->message);
        }
    }
}
