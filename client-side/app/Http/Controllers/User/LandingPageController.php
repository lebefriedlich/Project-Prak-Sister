<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LandingPageController extends Controller
{
    public function index()
    {
        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/event';
            $response = $client->request('GET', $apiUrl);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                return view('User.index', ['datas' => $body->data]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function daftarEvent(Request $request)
    {
        if (Cookie::has('api_token') && Cookie::has('user_id') && Cookie::get('user_role') === 'User') {
            $request->merge([
                'tanggal_daftar' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d')
            ]);

            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/user/pendaftaran';
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ],
                'form_params' => [
                    'id_user' => Cookie::get('user_id'),
                    'id_event' => $request->id_event,
                    'tanggal_daftar' => $request->tanggal_daftar,
                    'alasan_keikutsertaan' => $request->alasan_keikutsertaan,
                    'kategori_peserta' => $request->kategori_peserta
                ]
            ]);

            $body = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                return redirect()->route('landing-page')->with('success', $body->message);
            } else if ($response->getStatusCode() == 201) {
                return redirect()->back()->with('error', $body->message);
            }
        } else {
            return redirect()->back()->with('error', 'Kamu harus login terlebih dahulu.');
        }
    }

    public function myEvent()
    {
        try {
            $client = new Client();

            $apiUrl = config('app.api_url') . '/api/user/pendaftaran/' . Cookie::get('user_id');
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ]
            ]);
            
            $body = json_decode($response->getBody());
            
            $apiUrl = config('app.api_url') . '/api/user/pendaftaran/' . Cookie::get('user_id');
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cookie::get('api_token'),
                ]
            ]);
            

            if ($response->getStatusCode() == 200) {
                return view('User.listEvent', ['datas' => $body->data]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.' );
        }
    }

    public function createFeedback(Request $request)
    {
        $client = new Client();

        $apiUrl = config('app.api_url') . '/api/user/feedback';
        $response = $client->request('POST', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cookie::get('api_token'),
            ],
            'form_params' => [
                'id_pendaftaran' => $request->id_pendaftaran,
                'rating' => $request->rating,
                'komentar' => $request->komentar,
                'jenis_feedback' => $request->jenis_feedback
            ]
        ]);

        $body = json_decode($response->getBody());

        if ($response->getStatusCode() == 200) {
            return redirect()->route('my-event')->with('success', $body->message);
        } else if ($response->getStatusCode() == 201) {
            return redirect()->back()->with('error', $body->message);
        }
    }
}
